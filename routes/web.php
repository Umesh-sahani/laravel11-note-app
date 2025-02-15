<?php

use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;


Route::redirect('/', "/posts");

Route::post('/upload-image', [ImageUploadController::class, 'upload'])->name('upload.image');
// Route::post('/cleanup-images', [ImageUploadController::class, 'cleanupImages'])->name('cleanup.images');
Route::post('/cleanup-image', [ImageUploadController::class, 'cleanupImage'])->name('cleanup.image');

Route::resource('posts', PostController::class);
