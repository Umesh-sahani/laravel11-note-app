<?php

namespace App\Http\Controllers;

use App\Models\UploadImg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class ImageUploadController extends Controller
{

    public function upload(Request $request)
    {
        // Validate file input
        $request->validate([
            'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('uploads', $filename, 'public');

            // Store in database
            $image = UploadImg::create(['image' => $path]);

            return response()->json([
                'location' => asset('storage/' . $path),
                'id' => $image->id
            ]);
        }

        return response()->json(['error' => 'No file uploaded'], 400);
    }


    public function cleanupImages()
    {
        $recentImages = UploadImg::where('created_at', '>=', Carbon::now()->subDays(2))->get();
        foreach ($recentImages as $image) {
            $filePath = 'public/' . $image->image; // Ensure correct storage path

            if (Storage::exists($filePath)) {
                Storage::delete($filePath); // Delete the file
            }

            $image->delete(); // Remove from database
        }

        return response()->json(['message' => 'Old images deleted successfully']);
    }


}
