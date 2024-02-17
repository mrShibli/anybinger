<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::with('product')->latest()->paginate(12);

        return view('dashboard.brands.show', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands',
            'status' => 'required'
        ]);

        
        if($validator->passes()){
            $slug = Str::slug($request->name);
            Brand::create([
                'name' => $request->name,
                'slug' => $slug,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Brand Created succesfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
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
        $brand = Brand::find($id);
        if($brand == null){
            session()->flash('error', 'Brand not found');
            return redirect()->route('brands.index');
        }
        return view('dashboard.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);
        if(!$brand){
            return response()->json([
                'status' => 'redirect',
                'message' => 'Brand not found'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('brands')->ignore($brand->id),
            ],
            'status' => 'required'
        ]);

        
        if($validator->passes()){
            $slug = Str::slug($request->name);
            $brand->update([
                'name' => $request->name,
                'slug' => $slug,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'brand updated succesfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $brand = Brand::find($id);
        if(!$brand){
            return response()->json([
                'status' => false,
                'message' => 'Brand not found'
            ]);
        }

        $brand->destroy($brand->id);
        return response()->json([
            'status' => true,
            'message' => 'Brand successfully deleted'
        ]);
    }
}
