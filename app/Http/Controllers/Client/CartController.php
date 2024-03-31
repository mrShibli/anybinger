<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Darryldecode\Cart\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(){
        $carts = session()->get('cart', []);

        // Remove products from the session cart that are not found in the database
        $productIds = array_column($carts, 'pid');
        $existingProductIds = Product::whereIn('id', $productIds)->pluck('id')->toArray();
        $filteredCarts = array_filter($carts, function ($cart) use ($existingProductIds) {
            return in_array($cart['pid'], $existingProductIds);
        });

        // Sort the filtered carts
        usort($filteredCarts, function($a, $b) {
            return $a['pid'] - $b['pid'];
        });

        // Update the session cart with the filtered carts
        session()->put('cart', $filteredCarts);

        // Fetch products for the updated session cart
        $products = Product::with('productImage')->whereIn('id', $existingProductIds)->where('status', 'published')->get();
        
        $data['products'] = $products;
        $data['carts'] = $carts;
        return view('client.cart', $data);
    }
    
    public function cartCount(){
        $cartCount = 0;
        if(session()->has('cart')){
            $cartCount = count(session()->get('cart'));
        }

        return response()->json(['cartCount' => $cartCount]);
    }

    public function addToCart(Request $request, $id){

        $product = Product::where('status', 'published')->find($id);
        $qty = $request->qty ? $request->qty : 1;
        if(!$product){
            return response()->json([
                'status' => false,
                'error' => 'Product not found'
            ]);
        }

        $productId = $product->id;
        $oldCart = session()->get('cart', []);
        
        $existingCartItemIndex = collect($oldCart)->search(function ($item) use ($productId) {
            return $item['pid'] == $productId;
        });

        if ($existingCartItemIndex !== false) {
            return response()->json([
                'status' => 'inCart',
                'message' => $product->title.' already in cart'
            ]);
        } else {
            $oldCart[] = ['pid' => $productId, 'qty' => $qty];
        }

        session()->put('cart', $oldCart);
        return response()->json([
            'status' => true,
            'message' => $product->title.' added to cart'
        ]);
    }


    public function removeFromCart(Request $request){
        $pid = $request->id;
        $cart = session()->get('cart', []);

        $checkCart = array_search($pid, array_column($cart, 'pid'));

        if ($checkCart !== false) {
            unset($cart[$checkCart]);
            session()->put('cart', array_values($cart));

            return response()->json([
                'status' => true,
                'message' => 'Item removed from cart successfully'
            ]);
        } else {
            return response()->json([
                'status' => false,
                'error' => 'Item not found in the cart'
            ]);
        }
    }

    // public function updateCart(Request $request){
    //     $productId = $request->id;

    //     $product = Product::where('status', 'published')->find($productId);

    //     if (!$product) {
    //         return response()->json([
    //             'status' => false,
    //             'error'  => 'Product not found'
    //         ]);
    //     }

    //     $oldCart = session()->get('cart', []);

    //     $key = array_search($productId, array_column($oldCart, 'pid'));

    //     if ($key === false) {
    //         return response()->json([
    //             'status' => false,
    //             'error'  => 'Product not found in the cart'
    //         ]);
    //     }

    //     $qty = $oldCart[$key]['qty'];

    //     if ($request->work == 'increase') {
    //         $qty++;
    //     } elseif ($request->work == 'decrease' && $qty > 1) {
    //         $qty--;
    //     }

    //     $oldCart[$key]['qty'] = $qty;

    //     session()->put('cart', $oldCart);

    //     $price = $product->price;
    //     $totalPrice = $price * $qty;
    //     $subTotal = array_sum(array_column($oldCart, 'qty')) * $price;

    //     return response()->json([
    //         'status'     => true,
    //         'cartQty'    => $qty,
    //         'price'      => $price,
    //         'totalPrice' => $totalPrice,
    //         'subTotal'   => $subTotal,
    //         'message'    => 'Product quantity updated successfully'
    //     ]);
    // }



    public function updateCart(Request $request){

        $productId = $request->id;
        $qty = $request->qty ?? 1;
        $work = $request->work;

        $product = Product::where('status', 'published')->find($productId);

        if (!$product) {
            return response()->json([
                'status' => false,
                'error'  => 'Product not found'
            ]);
        }

        $oldCart = session()->get('cart', []);

        $key = array_search($productId, array_column($oldCart, 'pid'));

        if ($key === false) {
            return response()->json([
                'status' => false,
                'error'  => 'Product not found in the cart'
            ]);
        }

        $oldQty = $oldCart[$key]['qty'];

        if ($work == 'increase') {
            $qty = max(1, $oldQty + 1);
        } elseif ($work == 'decrease') {
            $qty = max(1, $oldQty - 1);
        }

        $oldCart[$key]['qty'] = $qty;
        session()->put('cart', $oldCart);

        $totalPrice = $product->price * $qty;

        // Recalculate subtotal based on product prices from the database
        $productIds = array_column($oldCart, 'pid');
        $products = Product::whereIn('id', $productIds)->get();
        $subTotal = $products->sum(function ($product) use ($oldCart) {
            return $product->price * $oldCart[array_search($product->id, array_column($oldCart, 'pid'))]['qty'];
        });

        return response()->json([
            'status'     => true,
            'cartQty'    => $qty,
            'price'      => $product->price,
            'totalPrice' => $totalPrice,
            'subTotal'   => $subTotal,
            'message'    => 'Product quantity updated successfully'
        ]);
    }



    


}
