<?php

namespace App\Http\Controllers;
use Intervention\Image\Facades\Image;
use App\Models\ProductImage;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class TempImageController extends Controller
{
    public function storeProductImage(Request $request){

        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:webp|max:256',
        ]);

        if ($validator->passes()) {
            $image = $request->file('image');

            if($image){
                $ext = $image->getClientOriginalExtension();
                $newName = time() . '.'. $ext;

                

                $filePath = public_path('/uploads/tempImage/');
                File::makeDirectory($filePath, 0755, true, true);

                // Save the resized image directly without creating a TempImage entry
                $img = Image::make($image->getRealPath())->resize(240, 240);
                $resizedName = time() . '_resized.' . $image->getClientOriginalExtension();
                $img->save($filePath . $resizedName);

                $tempImage = new TempImage;
                $tempImage->name = $resizedName;
                $tempImage->save();

                return response()->json([
                    'status' => true,
                    'imageId' => $tempImage->id,
                    'imagePath' => asset('/uploads/tempImage/'.$resizedName),
                    'message' => 'Image uploaded successfully'
                ]);
            }

        }

    }

    public function deleteProductImage(Request $request){
        $productImage = ProductImage::find($request->id);

        if(!$productImage){
            return response()->json([
                'status' => false,
                'errors' => 'Image not found'
            ]);
        }

        if(!empty($productImage->name)){
            $imagePath = public_path('/uploads/products/' . $productImage->name);
            if(file_exists($imagePath)){
                File::delete($imagePath);
            }
        }
        

        $productImage->destroy($productImage->id);
        return response()->json([
            'status' => true,
            'message' => 'Image removed successfully'
        ]);
        
    }
}
