<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\orderCancel;
use App\Mail\OrderMail;
use App\Models\Coupon;
use App\Models\DealerDescutn;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Transaction;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function orders(Request $request){
        $orders = Order::latest();
        $search = $request->search;

         if ($search) {
            $orders->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
                $query->orWhere('invoice_id', 'like', '%' . $search . '%');
            });
        }
        $orders = $orders->paginate(12);
        return view('dashboard.orders.show', compact('orders'));
    }

    public function payments(Request $request){
        $payments = Payment::latest();
        $search = $request->search;

         if ($search) {
            $payments->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
                $query->orWhere('payment_number', 'like', '%' . $search . '%');
            });
        }
        $payments = $payments->paginate(12);
        return view('dashboard.orders.payments', compact('payments'));
    }

    public function newOrders(Request $request){
        $orders = Order::where('status', 'pending')->latest();
        $search = $request->search;

         if ($search) {
            $orders->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
                $query->orWhere('invoice_id', 'like', '%' . $search . '%');
            });
        }
        $orders = $orders->paginate(12);
        return view('dashboard.orders.new', compact('orders'));
    }

    public function payOrders(Request $request){
        $orders = Order::where('status', 'pending_payment')->latest();
        $search = $request->search;

         if ($search) {
            $orders->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
                $query->orWhere('invoice_id', 'like', '%' . $search . '%');
            });
        }
        $orders = $orders->paginate(12);
        return view('dashboard.orders.pending', compact('orders'));
    }

    public function proOrders(Request $request){
        $orders = Order::whereIn('status' , ['approved', 'flight' ,'in_country', 'delivering', 'delivered'])->latest();
        $search = $request->search;

         if ($search) {
            $orders->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
                $query->orWhere('invoice_id', 'like', '%' . $search . '%');
            });
        }
        $orders = $orders->paginate(12);
        return view('dashboard.orders.processing', compact('orders'));
    }

    public function canOrders(Request $request){
        $orders = Order::where('status', 'cancelled')->latest();
        $search = $request->search;

         if ($search) {
            $orders->where(function ($query) use ($search) {
                $query->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                        ->orWhere('email', 'like', '%' . $search . '%')
                        ->orWhere('phone', 'like', '%' . $search . '%');
                });
                $query->orWhere('invoice_id', 'like', '%' . $search . '%');
            });
        }
        $orders = $orders->paginate(12);
        return view('dashboard.orders.cancelled', compact('orders'));
    }


    public function update($id){
        $order = Order::find($id);
        if(!$order){
            session()->flash('error', 'Order not found');
            return redirect()->route('orders.index');
        }
        $payments = Payment::where(['user_id' => $order->user_id, 'order_id' => $order->id])->get();
        return view('dashboard.orders.update', compact('order', 'payments'));
    }


    public function approvee(Request $request, $id){
        $order = Order::find($id);



        $validator = Validator::make($request->all(), [
            'fees' => 'required|numeric',
            'payment_type' => 'required|in:half,full,custom',
            'custom_amount' => 'required_if:payment_type,custom'
        ]);

        if($validator->passes()){

            $order->fees = $request->fees;
            $order->payment_type = $request->payment_type;
            $order->custom_amount = $request->custom_amount ? $request->custom_amount : 0;
            $order->status = 'pending_payment';
            $order->save();

            $amount = 0;
            if($order->payment_type == 'half'){
                $amount = ($order->total + $order->fees - $order->discount) / 2;
            }else if($order->payment_type == 'full'){
                $amount = $order->total + $order->fees - $order->discount;
            }else{
                $amount = $order->custom_amount ;
            }

            if($amount > $order->total + $order->fees - $order->discount){
                return response()->json([
                    'status' => false,
                    'errors' => 'Maxium payable amount is '. $order->total + $order->fees
                ]);
            }

            $payment = Payment::create([
                'user_id' => $order->user_id,
                'order_id' => $order->id,
                'pay_amount' => $amount,
                'status' => 'pending'
            ]);

            NotificationService::Notify($order->user_id, 'Your requested orderNo '.$order->invoice_id.'  reviewed and approved by administor , To confirm your order please pay '.$payment->pay_amount.'Tk', 'account.orders', $order->id);

            Mail::to($order->user->email)->send(new OrderMail($order,$payment));

            return response()->json([
                'status' => true,
                'message' => 'order has been approved'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }
    }


    public function itemUpdate(Request $request){
        try {
            DB::beginTransaction();

            if($request->type == 'custom'){
                $orderItem = orderItem::where(['id' => $request->id, 'product_id' => $request->product_id])->whereNot('status', 'cancelled')->first();
            }else{
                $orderItem = orderItem::where(['id' => $request->id, 'r_product_id' => $request->product_id])->whereNot('status', 'cancelled')->first();
            }

            $price = round(floatval($request->price), 0);

            $orderItem->price = $price;
            $orderItem->total = $price * $orderItem->qty;
            $orderItem->save();

            $order = $orderItem->order()->first();
            $orderItems = $order->orderItem()->whereNot('status', 'cancelled')->get();

            $orderTotal = 0;
            foreach($orderItems as $item){
                $orderTotal += $item->total;
            }

            $coupon = Coupon::where(['status' => 'published', 'code' => $order->discount_code])->first();
            if($coupon){
                $discountAmount = 0;
                if($coupon->min_amount < $orderTotal){
                    if($coupon->type == 'fixed'){
                        $discountAmount = $coupon->discount_amount;
                    }else{
                        $discountAmount = ($orderTotal / 100) * $coupon->discount_amount;
                    }
                    $order->discount_code = $coupon->code;
                    $order->discount = $discountAmount;
                }else{
                    $order->discount_code = 'Removed';
                    $order->discount = 0;
                }
            }else{
                $order->discount_code = 'Removed';
                $order->discount = 0;
            }

            $order->total = $orderTotal;
            $order->save();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Product price has been updated'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'status' => false,
                'errors' => 'Error updating product price',
            ]);
        }

    }


    public function updateStatus(Request $request, $id){
        $order = Order::find($id);

        $order->status = $request->status;
        if($request->status == 'cancelled'){
            Mail::to($order->user->email)->send(new orderCancel($order));
        }
        if($request->status == 'delivered' && $order->user->user_access == 'dealer'){
            $dealerDiscount = DealerDescutn::first()->descount_dealer;
            $order->user->balance = $order->user->balance + ($order->total / 100) * $dealerDiscount;
            $order->user->save();

            $transaction = Transaction::where('order_id', $order->id)->first();
            $transaction->status = 'completed';
            $transaction->save();
        }

        $order->admin_notes = $request->admin_notes;
        $order->save();

        NotificationService::Notify($order->user_id, 'Your orderNo '.$order->invoice_id.' status has been updated by administor', 'account.orders', $order->id);

        return response()->json([
            'status' => true,
            'message' => 'Order status upated successfully'
        ]);
    }


    public function deleteItem(Request $request){

        $orderItem = OrderItem::where(['order_id' => $request->order_id,'id' => $request->id ])->first();

        if(!$orderItem){
            return response()->json([
                'status' => false,
                'errors' => 'Order item not found',
            ]);
        }

        $orderItem->status = 'cancelled';
        $orderItem->save();

        $order = $orderItem->order()->first();
        $orderItems = $order->orderItem()->whereNot('status','cancelled')->get();

        if($orderItems->count() <= 0){
            $order->status = 'cancelled';
            NotificationService::Notify($order->user_id, 'Your orderNo '.$order->invoice_id.' and orderItem '.$orderItem->name.' has been cancelled by administor', 'account.orders', $order->id);
        }else{
            NotificationService::Notify($order->user_id, 'Your orderItem '.$orderItem->name.' has been cancelled by administor on orderNo '.$order->invoice_id.'', 'account.orders', $order->id);
        }
        $orderTotal = 0;
        foreach($orderItems as $item){
            $orderTotal += $item->total;
        }

        $coupon = Coupon::where(['status' => 'published', 'code' => $order->discount_code])->first();
        if($coupon){
            $discountAmount = 0;
            if($coupon->min_amount < $orderTotal){
                if($coupon->type == 'fixed'){
                    $discountAmount = $coupon->discount_amount;
                }else{
                    $discountAmount = ($orderTotal / 100) * $coupon->discount_amount;
                }
                $order->discount_code = $coupon->code;
                $order->discount = $discountAmount;
            }else{
                $order->discount_code = 'Removed';
                $order->discount = 0;
            }
        }else{
            $order->discount_code = 'Removed';
            $order->discount = 0;
        }

        $order->total = $orderTotal;
        $order->save();



        return response()->json([
            'status' => true,
            'message' => 'Item removed from customer order'
        ]);
    }

    public function createPayment(Request $request){
        $order = Order::where(['id' => $request->order_id, 'user_id' => $request->user_id])->first();

        if(!$order || $order->status == 'cancelled'){
            return response()->json([
                'status' => false,
                'errors' => 'Order not found'
            ]);
        }

        $payment = Payment::where(['order_id' => $request->order_id, 'user_id' => $request->user_id, 'status' => 'pending'])->latest()->first();

        if($payment){
            return response()->json([
                'status' => false,
                'errors' => 'Customer already have a pending payment'
            ]);
        }else{

            $maxAmount = $order->total + $order->fees - $order->discount;
            $paid = $order->paid;
            $dueAmount = $maxAmount - $paid;
            if($dueAmount < $request->amount){
                return response()->json([
                    'status' => false,
                    'errors' => 'Maximum payable amount '.$maxAmount -  $order->paid
                ]);
            }

            $paymentSaved = Payment::create([
                'user_id' => $request->user_id,
                'order_id' => $request->order_id,
                'pay_amount' => $request->amount
            ]);

            NotificationService::Notify($paymentSaved->user_id, 'Your orderNo '.$order->invoice_id.' has a pending payment of '.$paymentSaved->pay_amount.'Tk. Please pay it', 'account.orders', $order->id);

            return response()->json([
                'status' => true,
                'message' => 'New payment created successfully'
            ]);
        }

    }

    public function destroy($id){
        $order = Order::find($id);

        if(!$order){
            return response()->json([
                'status' => false,
                'errors' => 'Order not found'
            ]);
        }
        foreach($order->orderItem as $item){
            $item->delete();
        }

        NotificationService::Notify($order->user_id, 'Your orderNo '.$order->invoice_id.' has been deleted by administor', 'account.orders');

        $order->delete();
        return response()->json([
            'status' => true,
            'message' => 'Order deleted successfully'
        ]);
    }
    public function invoice ($id = null) {
        if ($id != null) {
            $order = Order::with('orderItem')->where('id', $id)->first();
            if ($order->status == 'delivered') {
                $logo = Setting::first();
                $data['order'] = $order;
                $data['logo'] = $logo;
                $pdf = Pdf::loadView('client.invoice', $data);
                return $pdf->download('anybringr_invoice.pdf');
            }
            return redirect()->back();
        }
        return redirect()->back();
    }
}
