<?php

namespace App\Http\Controllers\Client;

use App\Models\Review;
use App\Services\NotificationService;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductRequest;
use App\Models\TravelerProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index($search = null){
        $products = Product::where('status', 'published')->with(['category', 'productImage']);

        if ($search != null) {
            $products = $products->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        $products = $products->latest()->paginate(12);

        $data['products'] = $products;
        return view('client.products', $data);
    }

    public function product(Request $request, $slug){
        $product = Product::where('status', 'published')->where('slug',$slug)->first();

        if(!$product){
            return redirect()->back();
        }else{
            $reviews = Review::where(['status' => 'published', 'product_id' => $product->id])->latest()->paginate(8);
            $totalRating = Review::where('product_id', $product->id)
                        ->where('status', 'published')
                        ->avg('rating');
          return view('client.singleProduct', compact('product','reviews', 'totalRating'));
        }
    }


    public function categoryItems($category, $subcategory = null){

        $products = Product::where('status', 'published')->with('category');

        $products->whereHas('category', function ($query) use ($category) {
            $query->where('slug', $category);
        });
        if ($subcategory !== null) {
            $products->WhereHas('subcategory', function ($subQuery) use ($subcategory) {
                $subQuery->where('slug', $subcategory);
            });
        }

        $data['products'] = $products->paginate(18);
        $data['category'] = $category;
        $data['subcategory'] = $subcategory;
        return view('client.items', $data);
    }

    public function redirectSearch(Request $request){
        $search = $request->search;
        $validator = Validator::make(['search' => $search], [
            'search' => 'url',
        ]);

        if($validator->passes()){
            return response()->json([
                'status' => 'url',
                'search' => $search
            ]);
        }

        return response()->json([
            'status' => 'search',
            'search' => $search
        ]);
    }


    public function requestProduct(Request $request){
        $productUrl = $request->url;
        $validator = Validator::make(['search' => $productUrl], [
            'search' => 'url',
        ]);

        if($validator->passes()){
            return view('client.requestItem', compact('productUrl'));
        }else{
            return view('client.requestItem', compact('productUrl'));
        }
    }

    public function saveRequestProduct(Request $request){
        $validator = Validator::make($request->all(), [
            'url' => 'required|active_url|max:800',
            'notes' => 'required|max:255',
            'qty' => 'numeric'
        ]);

        if($validator->passes()){
            $validatedData = $validator->validated();
            $validatedData['user_id'] = Auth::user()->id;

            ProductRequest::create($validatedData);

            // NotificationService::Notify(Auth::user()->id, 'Requesting for url '.$request->url.'. And your request item qty is '.$request->qty, 'account.requests');

            return response()->json([
                'status' => true,
                'message' => "You've successfully requested for an item"
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }
    }

    public function myRequests(Request $request){
        $pending = ProductRequest::where(['user_id' => Auth::user()->id, 'status' => 'pending'])->latest()->get();
        $accepeted = ProductRequest::where(['user_id' => Auth::user()->id, 'status' => 'accepted'])->latest()->get();
        return view('client.account.requests', compact(['pending', 'accepeted']));
    }

    public function deleteRequest(Request $request){
        $requestItem = ProductRequest::find($request->id);

        if(!$requestItem){
            return response()->json([
                'status' => false,
                'errors' => 'Requested Item not found'
            ]);
        }

        $requestItem->delete();

        return response()->json([
            'status' => true,
            'message' => 'Requested Item has been removed'
        ]);
    }

    public function saveReview(Request $request, $id){
        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'status' => false,
                'errors' => 'Product not found'
            ]);
        }
        
        if(Auth::check()){

            $validator = Validator::make($request->all(), [
                'rating' => 'required|integer|min:1|max:5',
                'review' => 'required|string|max:2000',
            ],[
                'rating.required' => 'Please select a rating',
                'rating.integer' => 'The rating must be an integer.',
                'rating.min' => 'Please select a valid rating',
                'rating.max' => 'Please select a valid rating'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'errors' => $validator->errors()->first()
                ]);
            }


            Review::create([
                'user_id' => Auth::user()->id,
                'product_id' => $id,
                'rating' => $request->rating,
                'review' => $request->review
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Your review has been successfully submitted'
            ]);
        }else{
            return response()->json([
                'status' => 'loginRequired',
                'errors' => 'Please login to submit a review'
            ]);
        }
    }
}
