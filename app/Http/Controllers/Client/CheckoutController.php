<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\User;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\Setting;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;


class CheckoutController extends Controller
{

    public function checkout($type){
        $products = null;
        $productRequests = null;
        $carts = session()->get('cart', []);
        if($type == 'custom'){
            if(!$carts){
                return redirect()->route('cart');
            }

            $productIds = array_column($carts, 'pid');
            $existingProductIds = Product::whereIn('id', $productIds)->pluck('id')->toArray();

            $products = Product::with('productImage')->whereIn('id', $existingProductIds)->where('status', 'published')->get();
        }else if($type == 'request'){
            $productRequests = ProductRequest::where(['user_id' => Auth::user()->id, 'status' => 'accepted'])->latest()->get();
        }else{
            return redirect()->route('index');
        }


        $data['products'] = $products;
        $data['productRequests'] = $productRequests;
        $data['carts'] = $carts;
        $data['typeOfCheckout'] = $type;
        return view('client.checkout', $data);
    }

    public function coupons(Request $request){
        $coupon = Coupon::where(['code' => $request->code, 'status' => 'published'])->first();

        if(!$coupon){
            return response()->json([
                'status' => false,
                'errors' => "Coupon code doesn't exists"
            ]);
        }

        // Create DateTime objects for the provided date and current date
        $providedDate = \DateTime::createFromFormat('Y-m-d', $coupon->expire_date);
        $currentDate = new \DateTime();

        if($providedDate < $currentDate){
            return response()->json([
                'status' => false,
                'errors' => 'Coupon code has expired'
            ]);
        }

        $totalAmount = $request->totalAmount;
        $discountAmount = 0;

        if($coupon->min_amount < $totalAmount){
            if($coupon->type == 'fixed'){
                $discountAmount = $coupon->discount_amount;
            }else{
                $discountAmount = ($totalAmount / 100) * $coupon->discount_amount;
            }

            return response()->json([
                'status' => true,
                'discount' => $discountAmount,
                'code' => $coupon->code
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => 'You can use this coupon code when your order amount is more than '. $coupon->min_amount . 'TK'
            ]);
        }


    }

    public function storeOrder(Request $request){

        $redirectPage = '';

        $validator = Validator::make($request->all(), [
            'username' => 'required|min:5|max:30',
            'phone' => [
                'required',
                'min:11',
                'max:15',
                'regex:/^[0-9 -]+$/',
                Rule::unique('users')->ignore(Auth::user()->id)
            ],
            'address' => 'required|max:70',
            'city' => 'required|max:20',
            'zone' => 'required',
            'notes' => 'nullable|max:255',
            'typeOfCheckout' => ['required', 'in:custom,request']
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();

        try{
        $id = Auth::id();
        $user = User::find($id);
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->zone = $request->zone;
        $user->save();

        $order = new Order([
            'user_id' => $id,
            'discount' => 0,
            'fees' => 0,
            'total' => 0,
            'notes' => $request->notes,
            'invoice_id' => '#'
        ]);

        $user->orders()->save($order);
        $order->invoice_id = '#' . $order->id . $user->id .random_int(1111, 9999);
        $order->save();

        $productItems = [];
        $totalOrderAmount = 0;

        if ($request->typeOfCheckout == 'custom') {
            $redirectPage = 'cart';
            $carts = session()->get('cart', []);
            $productIds = array_column($carts, 'pid');
            $existingProductIds = Product::whereIn('id', $productIds)
                ->pluck('id')->toArray();

            $products = Product::with('productImage')
                ->whereIn('id', $existingProductIds)
                ->where('status', 'published')->get();

            if ($products->isEmpty()) {
                return response()->json([
                    'status' => 'notFound',
                    'errors' => 'No products found',
                ]);
            }

            foreach ($products as $key => $product) {
                $qty = $carts[$key]['qty'];
                $total = $product->price * $qty;

                $productItems[] = [
                    'user_id' => $id,
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'name' => $product->title,
                    'price' => $product->price,
                    'qty' => $qty,
                    'total' => $total,
                    'image' => optional($product->productImage()->latest()->first())->name,
                ];

                $totalOrderAmount += $total;
            }

            // Clear cart session
            session()->forget('cart');
        } elseif ($request->typeOfCheckout == 'request') {
            $redirectPage = 'requests#accepted';

            $productRequests = ProductRequest::where(['user_id' => $id, 'status' => 'accepted'])
                ->latest()->get();

            if ($productRequests->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'errors' => 'Product not found',
                ]);
            }

            foreach ($productRequests as $product) {
                $total = $product->original_price * $product->qty;
                $productItems[] = [
                    'user_id' => $id,
                    'order_id' => $order->id,
                    'r_product_id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->original_price,
                    'qty' => $product->qty,
                    'total' => $total,
                    'image' => $product->image,
                ];
                $totalOrderAmount += $total;
                $product->delete();
            }
        }

        if($user->user_access == 'dealer'){
            $dealerDiscount = \App\Models\DealerDescutn::first()->descount_dealer;
            $discountOfDealer = ($totalOrderAmount / 100) * $dealerDiscount ;

            Transaction::create([
                'user_id' => $user->id,
                'order_id' => $order->id,
                'amount' => $discountOfDealer,
                'type' => 'discount',
                'status' => 'awating'
            ]);
        }

        OrderItem::insert($productItems);


        if(!empty($request->couponCode)){
            $coupon = Coupon::where(['code' => $request->couponCode, 'status' => 'published'])->first();

            if(!$coupon){
                return response()->json([
                    'status' => false,
                    'errors' => "Coupon code doesn't exists"
                ]);
            }

            $discountAmount = 0;

        if($coupon->min_amount < $totalOrderAmount){
            if($coupon->type == 'fixed'){
                $discountAmount = $coupon->discount_amount;
            }else{
                $discountAmount = ($totalOrderAmount / 100) * $coupon->discount_amount;
            }
            $order->discount_code = $coupon->code;
            $order->discount = $discountAmount;
        }else{
            return response()->json([
                'status' => false,
                'errors' => 'You can use this coupon code when your order amount is more than '. $coupon->min_amount . 'TK'
            ]);
        }


        }

        $order->total = $totalOrderAmount;
        $order->save();

            DB::commit();
        }catch(\Exception $e){
            DB::rollBack();

            return response()->json([
                'status' => false,
                'errors' => 'Something went wrong'
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Order request has been sent',
            'redirect' => $redirectPage,
        ]);
    }

    public function orders($id = null){
        if($id != null){

            $payment = Payment::where(['user_id' => Auth::user()->id, 'order_id' => $id, 'status' => 'pending'])->latest()->first();
            $payments = Payment::where(['user_id' => Auth::user()->id, 'order_id' => $id])->latest()->get();
            $order = Order::with('orderItem')->where(['id' => $id, 'user_id' => Auth::user()->id])->first();
            if(!$order){
                return redirect()->route('account.orders');
            }
            return view('client.account.orderDetails', compact('order','payment','payments'));
        }
        $orders = Order::where(['user_id' => Auth::user()->id])->latest()->paginate(10);
        return view('client.account.orders', compact('orders'));
    }

    public function invoice ($id = null) {
        if ($id != null) {
            $order = Order::with('orderItem')->where(['id' => $id, 'user_id' => Auth::user()->id])->first();
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
