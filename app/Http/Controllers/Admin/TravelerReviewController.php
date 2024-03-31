<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TravelerReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TravelerReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $travelerreviews = TravelerReview::latest()->paginate(12);
        return view('dashboard.travelerreview.show', compact('travelerreviews'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.travelerreview.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:35',
            'about' => 'required|max:50',
            'review' => 'required|min:20',
        ]);


        if($validator->passes()){
            TravelerReview::create([
                'name' => $request->name,
                'about'  => $request->about,
                'review'  => $request->review
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Traveler Review Added'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
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
        $travelerreview = TravelerReview::find($id);

        if(!$travelerreview){
            session()->flash('errors', 'Traveler review not found');
            return redirect()->route('travelerreviews.index');
        }

        return view('dashboard.travelerreview.edit', compact('travelerreview'));  

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $travelerreview = TravelerReview::find($id);

        if(!$travelerreview){
            return response()->json([
                'status' => false,
                'errors' => 'Traveler review not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:35',
            'about' => 'required|max:50',
            'review' => 'required|min:20',
        ]);


        if($validator->passes()){
            $travelerreview->update([
                'name' => $request->name,
                'about'  => $request->about,
                'review'  => $request->review
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Traveler review updated successfully'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $travelerreview = TravelerReview::find($id);

        if(!$travelerreview){
            return response()->json([
                'status' => false,
                'errors' => 'Traveler review not found'
            ]);
        }

        $travelerreview->delete();
        return response()->json([
            'status' => true,
            'message' => 'Traveler review deleted successfully'
        ]);
    }
}
