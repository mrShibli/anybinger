<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\ProductImage;
use App\Models\ProductRequest;
use App\Models\SpecialProduct;
use App\Models\TempImage;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::latest(); 
        $search = $request->search;

        if ($search) {
            $products->where(function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        $products = $products->with(['category', 'productImage'])->paginate(12);

        return view('dashboard.products.show', compact('products'));
    }

    public function specialProduct(){
        $product = SpecialProduct::with('product')->first();
        
        return view('dashboard.products.special', compact(['product']));
    }   

    public function makeSpecial($id)
    {
        $product = Product::find($id);

        if (!$product) {
            session()->flash('error', 'Product not found');
            return redirect()->route('products.index');
        }

        $specialProduct = SpecialProduct::first();

        if (!$specialProduct) {
            // Create a new special product if none exists
            $specialProduct = new SpecialProduct();
        }

        $specialProduct->product_id = $product->id;
        $specialProduct->save();

        session()->flash('success', 'Product added to special list');
        return redirect()->route('products.index');
    }

    public function deleteSpecial($id){
        $product = Product::find($id);

        if(!$product){
            session()->flash('error', 'Product not found');
            return redirect()->route('products.index');
        }
        $specialProduct = SpecialProduct::where('product_id',$id);
        
        $specialProduct->delete();
        session()->flash('success', 'Product delete form special list'); 
        return redirect()->route('products.specialProduct');
    }

    public function requests(){
        $requests = ProductRequest::with('user')->latest()->paginate(12);
        return view('dashboard.products.requests', compact('requests'));
    }

    public function requestsView($id){
        $request = ProductRequest::with('user')->find($id);

        if(!$request){
            session()->flash('error', 'Request product not found');
            return redirect()->route('products.requests');
        }

        return view('dashboard.products.checkRequest', compact('request'));
    }

    public function acceptRequest(Request $request, $id){
        $requestProduct = ProductRequest::find($id);

        if(!$requestProduct){
            return response()->json([
                'status' => false,
                'errors' => 'Request product not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:80',
            'price' => 'required|integer',
            'image' => 'required|mimes:webp,jpg,png|max:256'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }

        if ($request->has('image')) {
            $image = $request->file('image');
            $ext = $image->getClientOriginalExtension();

            $imageName = time() . '.' . $ext;
            $destination = public_path('uploads/requests/');
            $image->move($destination, $imageName);
            $requestProduct->image = $imageName;
        }

        $requestProduct->name = $request->name;
        $requestProduct->qty = $request->qty;
        $requestProduct->original_price = $request->price;
        $requestProduct->status = 'accepted';
        $requestProduct->save();

        NotificationService::Notify($requestProduct->user_id, 'Your requested product '.$requestProduct->url.' has been approved', 'account.requests');

        return response()->json([
            'status' => true,
            'message' => 'Product request accepted'
        ]);
    }

    public function deleteRequest(Request $request, $id){
        $requestProduct = ProductRequest::find($id);

        if(!$requestProduct){
            return response()->json([
                'status' => false,
                'errors' => 'Request product not found'
            ]);
        }
        $imagePath = public_path('uploads/requests/' . $requestProduct->image);
        if($requestProduct->image != '' && file_exists($imagePath)){
            File::delete($imagePath);
        }
        
        NotificationService::Notify($requestProduct->user_id, 'Your requested product '.$requestProduct->url.' has been cancelled. Reason: '.$request->reason.'', 'account.notifications');

        $requestProduct->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product request declined successfully'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $data['categories'] = Category::where('status', 'published')->latest()->get();
        $data['brands'] = Brand::where('status', 'published')->latest()->get();
        return view('dashboard.products.create', $data);

    }


    public function subcategories(Request $request){

        $category = Category::where('status', 'published')->find($request->id);
        if(!$category){
            return response()->json([
                'status' => false
            ]);
        }

        $subcategory = SubCategory::where('category_id', $category->id)->get();
        return response()->json([
            'status' => true,
            'subcategory' => $subcategory
        ]);

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->descriptions);
        
        $rules = [
            'title' => 'required|unique:products|max:70',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'status' => 'required',
            'descriptions' => 'required',
            'short_description' => 'required|max:255',
            'tags' => 'required|max:255',
            'meta_keyword' => 'required|max:100',
            'meta_description' => 'required|max:255',
        ];

        $track_qty = 'No';
        $quantity = null;
        if(!empty($request->track_quantity) && $request->track_quantity  == 'Yes'){
            $rules['quantity'] = 'required|numeric';
            $track_qty = 'Yes';
            $quantity = $request->quantity;
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $slug = Str::slug($request->title);
        $product = Product::create([
            'title' => $request->title,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'short_description' => $request->short_description,
            'description' => $request->descriptions,
            'tags' => $request->tags,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'track_quantity' => $track_qty,
            'quantity' => $quantity,
            'status' => $request->status
        ]);

        if(!empty($request->image_array)){
            foreach($request->image_array as $image){
                $tempImage = TempImage::find($image);
                $newName = $product->id . $tempImage->name;

                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->name = $newName;
                $productImage->save();

                $sourcePath = public_path('/uploads/tempImage/' . $tempImage->name);
                $outputPath = public_path('/uploads/products/' . $newName);

                if (File::exists($sourcePath)) {
                    File::move($sourcePath, $outputPath);
                    if (File::exists($outputPath)) {
                        File::delete($sourcePath);
                    }
                }

            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Product added successfully'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::find($id);

        if(!$product){
            session()->flash('error', 'Product not found');
            return redirect()->route('products.index');
        }
        $productImages = $product->productImage->all();
        $data['productImages'] = $productImages;
        $data['product'] = $product;
        $data['categories'] = Category::where('status', 'published')->latest()->get();
        $data['brands'] = Brand::where('status', 'published')->latest()->get();
        return view('dashboard.products.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'status' => 'notFound',
                'errors' => 'product not found'
            ]);
        }
        
        $rules = [
            'title' => [
                'required',
                'max:70',
                Rule::unique('products')->ignore($id)
            ],
            'category_id' => 'required',
            'price' => 'required|numeric',
            'status' => 'required',
            'descriptions' => 'required',
            'short_description' => 'required|max:255',
            'tags' => 'required|max:255',
            'meta_keyword' => 'required|max:100',
            'meta_description' => 'required|max:255',
        ];

        $track_qty = 'No';
        $quantity = null;
        if(!empty($request->track_quantity) && $request->track_quantity  == 'Yes'){
            $rules['quantity'] = 'required|numeric';
            $track_qty = 'Yes';
            $quantity = $request->quantity;
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }

        $slug = Str::slug($request->title);
        $product->update([
            'title' => $request->title,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'compare_price' => $request->compare_price,
            'short_description' => $request->short_description,
            'description' => $request->descriptions,
            'tags' => $request->tags,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
            'track_quantity' => $track_qty,
            'quantity' => $quantity,
            'status' => $request->status
        ]);

        if(!empty($request->image_array)){
            foreach($request->image_array as $image){
                $tempImage = TempImage::find($image);
                $newName = $product->id . $tempImage->name;

                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->name = $newName;
                $productImage->save();

                $sourcePath = public_path('/uploads/tempImage/' . $tempImage->name);
                $outputPath = public_path('/uploads/products/' . $newName);

                if (File::exists($sourcePath)) {
                    File::move($sourcePath, $outputPath);
                    if (File::exists($outputPath)) {
                        File::delete($sourcePath);
                    }
                }

            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Product updated successfully'
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if(!$product){
            return response()->json([
                'status' => false,
                'error' => 'Product not found'
            ]);
        }
        // dd($product->productImage);
        if(!empty($product->productImage)){
            foreach($product->productImage as $image){
                $imagePath = public_path('/uploads/products/' . $image->name);
                if(file_exists($imagePath)){
                    File::delete($imagePath);
                }
                
            }
        }

        $product->destroy($product->id);

        return response()->json([
            'status' => true,
            'messsage' => 'Product successfully deleted'
        ]);
    }
}
