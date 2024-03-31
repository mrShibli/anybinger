<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = SubCategory::with('category')->latest()->paginate(12);
        return view('dashboard.subcategories.show', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::latest()->get();
        return view('dashboard.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:subcategories',
            'category_id' => 'required|integer',
            'status' => 'required'
        ]);

        
        if($validator->passes()){
            $slug = Str::slug($request->name);
            SubCategory::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => $slug,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'SubCategory Created succesfully'
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
        $categories = Category::latest()->get();
        $subcategory = SubCategory::find($id);
        if($subcategory == null){
            session()->flash('error', 'Category not found');
            return redirect()->route('categories.index');
        }
        return view('dashboard.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $subcategory = SubCategory::find($id);
        if(!$subcategory){
            return response()->json([
                'status' => 'redirect',
                'message' => 'subcategory not found'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('subcategories')->ignore($subcategory->id),
            ],
            'category_id' => 'required|integer',
            'status' => 'required'
        ]);

        
        if($validator->passes()){
            $slug = Str::slug($request->name);
            $subcategory->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => $slug,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'SubCategory updated succesfully'
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
        $category = SubCategory::find($id);
        if(!$category){
            return response()->json([
                'status' => false,
                'message' => 'SubCategory not found'
            ]);
        }

        $category->destroy($category->id);
        return response()->json([
            'status' => true,
            'message' => 'SubCategory successfully deleted'
        ]);
    }
}
