<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', "/posts");

Route::resource('posts', PostController::class);

Route::post('/upload-image', function (Request $request) {
    $request->validate([
        'file' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

    $path = $request->file('file')->store('uploads', 'public');
    return response()->json(['location' => asset('storage/' . $path)]);
});
