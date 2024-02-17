<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(){
        $reviews = Review::latest()->paginate(12);

        return view('dashboard.reviews.show', compact('reviews'));
    }

    public function approve($id){
        $review = Review::find($id);
        if(!$review){
            session()->flash('error', 'Review not found');
            return redirect()->route('reviews.index');
        }

        $review->status = 'published';
        $review->save();
        
        session()->flash('success', 'Review approved');
        return redirect()->route('reviews.index');

    }

    public function delete($id){
        $review = Review::find($id);
        if(!$review){
            session()->flash('error', 'Review not found');
            return redirect()->route('reviews.index');
        }

        $review->delete();
        
        session()->flash('success', 'Review deleted');
        return redirect()->route('reviews.index');
    }
}
