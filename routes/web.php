<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');



    Route::get('posts',[PostController::class,'index'])->name('posts.index');
    Route::get('posts/create',[PostController::class,'create'])->name('posts.create');
    Route::post('posts/',[PostController::class,'store'])->name('posts.store');
    Route::get('posts/{id}/edit',[PostController::class,'edit'])->name('posts.edit');
    Route::post('posts/{id}',[PostController::class,'update'])->name('posts.update');
    
});

require __DIR__.'/auth.php';
