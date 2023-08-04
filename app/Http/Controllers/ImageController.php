<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Image;
use Intervention\Image\Facades\Image as Resize;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function showUploadForm()
    {
        return view('upload');
    }

    public function uploadAndResize(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Adjust the validation rules as needed
        ]);

        $imagePath = $request->file('image')->store('public');
        $imageName = basename($imagePath);
        // dd($imageName);
        // Resize the image
        $img = Resize::make(storage_path('app/' . $imagePath));
        $img->resize(300, 200);
        $resizedImagePath = 'resized_' . $imageName;
        $img->save(storage_path('app/public/images/' . $resizedImagePath));

        // Get image sizes
        $originalSize = File::size(storage_path('app/' . $imagePath));
        $resizedSize = File::size(storage_path('app/public/images/' . $resizedImagePath));



        // Store image information in the database
        $image = new Image();
        $image->image_path = $imageName;
        $image->resized_image_path = $resizedImagePath;
        $image->image_original_size = $originalSize;
        $image->image_resized_size = $resizedSize;
        $image->save();

        return redirect()->back()->with('success', 'Image uploaded and resized successfully.');
    }
    public function showImages($id)
    {
        $image = Image::findOrFail($id);
    
        $originalImagePath = asset('storage/' . $image->image_path);
        $resizedImagePath = asset('storage/images/'. $image->resized_image_path);
        return view('show', compact('originalImagePath', 'resizedImagePath'));
    }
    
}
