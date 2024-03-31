<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::latest()->paginate(12);
        return view('dashboard.faqs.show', compact('faqs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.faqs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:20',
            'show_on' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }

        Faq::create([
            'title' => $request->title,
            'description' => $request->description,
            'show_on' => $request->show_on,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'New Faqs created 🎉'
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
        $faq = Faq::find($id);

        if(!$faq){
            session()->flash('errors', 'Faq not found');
            return redirect()->route('faqs.index');
        }

        return view('dashboard.faqs.edit', compact('faq'));        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $faq = Faq::find($id);
        if(!$faq){
            return response()->json([
                'status' => false,
                'errors' => 'Faq not found'
            ]);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required|min:20',
            'show_on' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }else{
            $faq->update([
                'title' => $request->title,
                'description' => $request->description,
                'show_on' => $request->show_on,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Faq updated successfully'
            ]);
        }

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faq = Faq::find($id);

        if(!$faq){
            return response()->json([
                'status' => false,
                'errors' => 'Faq not found'
            ]);
        }

        $faq->delete();
        return response()->json([
            'status' => true,
            'message' => 'Faq deleted successfully'
        ]);
    }
}
