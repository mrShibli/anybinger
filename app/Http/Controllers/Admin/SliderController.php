<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::latest()->paginate(12);
        return view('dashboard.sliders.show', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.sliders.create');
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'max:14',
            'link' => 'required|active_url|max:200',
            'image' => 'required|mimes:webp|max:256',
            'status' => 'required'
        ]);

        if ($validator->passes()) {

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $ext = $image->getClientOriginalExtension();
                $newName = time() . '.' . $ext;

                $sourcePath = public_path('uploads/tempImage/');
                $dst = public_path('uploads/sliders/');
                $image->move($sourcePath, $newName);

                // Resize the image
                $resizedImage = Image::make($sourcePath . $newName)->resize(1365, 519);
                $resizedImage->save($dst . $newName); 


                Slider::create([
                    'text' => $request->text ?? '',
                    'link' => $request->link,
                    'image' => $newName,
                    'status' => $request->status
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Slider created successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'errors' => 'Please submit an image'
                ]);
            }
        } else {
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
        $slides = Slider::find($id);

        if(!$slides){
            session()->flash('error', 'No slides found');
            return redirect()->route('sliders.index');
        }

        return view('dashboard.sliders.edit', compact('slides'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(){
    
    }
    public function updatee(Request $request, int $id)
    {
        $slides = Slider::find($id);

        if(!$slides){
            return redirect()->json([
                'status' => false,
                'errors' => 'Slides not found'
            ]);
        }

        $validator = Validator::make($request->all(), [
            'text' => 'max:14',
            'link' => 'required|active_url|max:200',
            'image' => 'mimes:webp|max:256',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()->first()
            ]);
            
        } else {
            $oldPath = public_path('uploads/sliders/');
            $oldImage = $slides->image;

            if ($request->hasFile('image')) {
                // remove old image 
                if(file_exists($oldPath.$oldImage)){
                    File::delete($oldPath.$oldImage);
                }
                
                // first save at temp folder
                $image = $request->file('image');
                $ext = $image->getClientOriginalExtension();
                $newName = time() . '.' . $ext;
                $dsPath = public_path('uploads/tempImage/');
                $image->move($dsPath, $newName);

                // Resize the image and save it in destination
                $resizedImage = Image::make($dsPath . $newName)->resize(1365, 519);
                $resizedImage->save($oldPath . $newName); 

                $slides->update([
                    'text' => $request->text ?? '',
                    'link' => $request->link,
                    'image' => $newName,
                    'status' => $request->status
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Slider updated successfully'
                ]);
            } else {
                $slides->update([
                    'text' => $request->text ?? '',
                    'link' => $request->link,
                    'status' => $request->status
                ]);
                return response()->json([
                    'status' => true,
                    'message' => 'Slider updated successfully'
                ]);
            }
        }


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $slider = Slider::find($id);

        if(!$slider){
            return response()->json([
                'status' => false,
                'errors' => 'Slider not found'
            ]);
        }

        $imagePath = public_path('/uploads/sliders/'.$slider->image);
        if(file_exists($imagePath)){
            File::delete($imagePath);
        }

        $slider->destroy($slider->id);

        return response()->json([
            'status' => true,
            'message' => 'Slides deleted successfully'
        ]);
    }
}
