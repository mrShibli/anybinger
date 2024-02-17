<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class AccountController extends Controller
{
    public function account(){
        $transactions = Transaction::where('user_id', Auth::user()->id)->latest()->paginate(12);
        $orderCount = Order::where('user_id', Auth::user()->id)->count();
        $productreqCount = ProductRequest::where('user_id', Auth::user()->id)->count();
        return view('client.account.index', compact('transactions','orderCount','productreqCount'));
    }

    public function Notifications(){
        $notifications = Notification::where('user_id', Auth::user()->id)->latest()->paginate(50);
        return view('client.account.notifications', compact('notifications'));
    }

    public function Transactions(){
        $payments = Payment::with('order')->where('user_id', Auth::user()->id)->latest()->paginate(12);

        return view('client.account.transactions', compact('payments'));
    }

    public function updateProfile(Request $request){
        $user = User::find(Auth::user()->id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:4|max:50',
            'password' => 'nullable|min:6|max:50',
            'phone' => 'required|min:11|max:15|unique:users,phone,'.$user->id.'|max:50'
        ]);

        if($validator->passes()){
            $user->update([
                'name' => $request->name,
                'password' => $request->password ? bcrypt($request->password) : $user->password,
                'phone' => $request->phone
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors()->first()
        ]);
    }

    public function wishlists(){
        $wishlists = Wishlist::with('product')->where('user_id', Auth::user()->id)->latest()->paginate(12);
        return view('client.wishlists', compact('wishlists'));
    }

    public function addToWishlist(Request $request){
        $product = Product::find($request->id);
        if (!$product) {
            
        }

        if(!Auth::check()){
            return response()->json([
                'status' => 'Unauthorized',
                'errors' => 'Login to save on wishlist'
            ]);
        }

        $wishlist = Wishlist::where(['product_id' => $product->id, 'user_id' => Auth::user()->id])->first();

        if($wishlist){
            return response()->json([
                'status' => false,
                'errors' => $product->title . ' already in wishlist'
            ]);
        }else{
            Wishlist::create([
                'product_id' => $product->id,
                'user_id' => Auth::user()->id
            ]);

            return response()->json([
                'status' => true,
                'message' => $product->title . ' added to wishlist'
            ]);
        }
    }


    public function removeFromWishlist(Request $request){
        $wishlist = Wishlist::find($request->id);
        
        if(!$wishlist){
            return response()->json([
                'status' => false,
                'errors' => 'Wishlisted item not found'
            ]);
        }

        $wishlist->delete();
        return response()->json([
            'status' => true,
            'message' => 'Product removed from wishlist'
        ]);
    }

    public function updateAddress(Request $request){
        $user = User::find(Auth::user()->id);

        $validator = Validator::make($request->all(), [
            'phone' => 'required|min:11|max:15|unique:users,phone,'.$user->id.'|max:50',
            'address' => 'required|max:60',
            'city' => 'required|max:30',
            'zone' => 'required|max:20'
        ]);

        if($validator->passes()){
            $user->phone = $request->phone;
            $user->address = $request->address;
            $user->city = $request->city;
            $user->zone = $request->zone;
            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Address updated successfully'
            ]);
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors()->first()
        ]);
    }

    public function withdraw(Request $request){
        $user = User::find(Auth::user()->id);
        $transaction = Transaction::where(['user_id' => $user->id, 'status' => 'awaiting'])->latest()->first();
        if($transaction){
            return response()->json([
                'status' => false,
                'errors' => 'You already have a pending withdrawal'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'phone' => 'required|regex:/^01[3-9]\d{8}$/',
            'amount' => 'required|numeric'
        ]); 

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]); 
        }

        if($user->balance >= $request->amount){
            if ($request->amount >= 100) {
                $user->balance -= $request->amount;
                $user->save();

                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'withdraw',
                    'phone' => $request->phone,
                    'amount' => $request->amount,
                    'status' => 'awaiting'
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Withdrawal request placed'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => 'Minimum withdrawal amount is 100Tk'
                ]);  
            }
        }else{
            return response()->json([
                'status' => false,
                'errors' => 'Insufficient balance'
            ]);
        }
        
    }

    public function payFromWallet($order_id, $payment_id){
        $user = User::find(Auth::user()->id);
        $payment = Payment::find($payment_id);
        $order = Order::find($order_id);
        if($user->balance >= $payment->pay_amount){
            
            $user->balance = $user->balance - $payment->pay_amount;
            $user->save();

            $payment->status = 'paid';
            $payment->payment_number = 'Paid from wallet';
            $payment->trxID = 'Paid from wallet';
            $payment->paymentID = 'Paid from wallet';
            $payment->save();
            
            if($order->status == 'pending_payment'){
                $order->status = 'approved';
            }
            $order->paid = $order->paid + $payment->pay_amount;
            $order->save();
            session()->flash('success', "You've paid ".$payment->pay_amount.'Tk from your wallet');
            return redirect()->route('account.orders', $order->id);
        }else{
            session()->flash('error', 'Insufficient balance in your wallet');
            return redirect()->route('account.orders', $order->id);
        }
    

    }
}
