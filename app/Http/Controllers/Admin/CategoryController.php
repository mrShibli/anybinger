<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with('product')->latest()->paginate(12);
        return view('dashboard.categories.show', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories',
            'show_home' => 'required',
            'status' => 'required'
        ]);

        
        if($validator->passes()){
            $slug = Str::slug($request->name);
            Category::create([
                'name' => $request->name,
                'slug' => $slug,
                'show_home' => $request->show_home,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Category Created succesfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        if($category == null){
            session()->flash('error', 'Category not found');
            return redirect()->route('categories.index');
        }
        return view('dashboard.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::find($id);
        if(!$category){
            return response()->json([
                'status' => 'redirect',
                'message' => 'Category not found'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                Rule::unique('categories')->ignore($category->id),
            ],
            'show_home' => 'required',
            'status' => 'required'
        ]);

        
        if($validator->passes()){
            $slug = Str::slug($request->name);
            $category->update([
                'name' => $request->name,
                'slug' => $slug,
                'show_home' => $request->show_home,
                'status' => $request->status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Category updated succesfully'
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
        $category = Category::find($id);
        if(!$category){
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ]);
        }

        $category->delete();
        return response()->json([
            'status' => true,
            'message' => 'Category successfully deleted'
        ]);
    }
}
