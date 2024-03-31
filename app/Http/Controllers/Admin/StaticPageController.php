<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\StaticPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class StaticPageController extends Controller
{
    public function index(){
        
        $staticpages = StaticPage::latest()->paginate(12);
        return view('dashboard.staticpages.show', compact('staticpages'));
    }


    public function edit(int $id){
        $staticpage = StaticPage::find($id);

        if(!$staticpage){
            session()->flash('error', 'Static Page not found');
            return redirect()->route('subcategories.index');
        }

        return view('dashboard.staticpages.edit', compact('staticpage'));
    }

    public function update(Request $request, int $id){
        $staticpage = StaticPage::find($id);

        if(!$staticpage){
            return response()->json([
                'status' => false,
                'errors' => 'SubCategory not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'description' => 'required',
            'meta_keyword' => 'required',
            'meta_description' => 'required'
        ]);

        if($validator->passes()){

            $staticpage->update([
                'name' => $staticpage->name,
                'slug' => $staticpage->slug,
                'description' => $request->description,
                'meta_keyword' => $request->meta_keyword,
                'meta_description' => $request->meta_description
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Static pages updated successfully'
            ]); 
        }

        return response()->json([
            'status' => false,
            'errors' => $validator->errors()->first()
        ]);

    }
}
