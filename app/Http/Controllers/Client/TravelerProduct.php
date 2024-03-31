<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\ProductRequest;
use App\Models\TravelerProduct as ModelsTravelerProduct;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TravelerProduct extends Controller
{
    public function index(){
        $ids = ModelsTravelerProduct::pluck('product_request_id')->toArray();
        $travelerProduct = ProductRequest::where('status', 'accepted')->whereNotIn('id', $ids)->get();

        return view("client.travelerProduct", compact('travelerProduct'));
    }

    public function add(Request $request)
    {
        $reProduct = intval($request->id);

        $travelerHaProduct = ModelsTravelerProduct::where('product_request_id', $reProduct)->first();

        if (!$travelerHaProduct) {
            // Retrieve the authenticated user with the 'traveler' role
            $user = Auth::user();
            if ($user && $user->user_access == 'traveler') {
                // Create a new ModelsTravelerProduct instance
                $travelerProduct = new ModelsTravelerProduct;
                $travelerProduct->traveler_id = $user->traveler->id;
                $travelerProduct->product_request_id = $reProduct;
                // $travelerProduct->status = null;
                $travelerProduct->save();

                return response()->json(
                    [
                        'success' => 'Added',

                    ],200
                );
            } else {
                // Handle the case where the authenticated user is not a 'traveler'
                return response()->json(
                    [
                        'faild', 'User is not a traveler',
                    ],404
                );
            }
        } else {
            // Handle the case where the product is already added
            return response()->json(
                [
                    'status' => false,
                    'faild' => 'Product already added by other traveler'
                ]
            );
        }
    }
    public function delete (Request $request)
    {
       $data =  ModelsTravelerProduct::find($request->id);
       $data->delete();
       return response()->json(['success'=> true,'message'=> 'Cencle & Deleted Treveler!']);
    }

    public function statusProduct (Request $request) {
        $product = ModelsTravelerProduct::find($request->id);
        $product->status = 'confirmed';
        $product->save();
        return response()->json(['success'=> true,'message'=> 'confirmed Product!']);
    }


}
