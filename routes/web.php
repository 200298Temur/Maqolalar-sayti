<?php

use App\Http\Controllers\CategoryController;
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


    Route::get('posts/show/{id}', [PostController::class, 'show'])->name('posts.show'); 
    Route::get('posts',[PostController::class,'index'])->name('posts.index');
    Route::get('posts/create',[PostController::class,'create'])->name('posts.create');
    Route::post('posts/',[PostController::class,'store'])->name('posts.store');
    Route::get('posts/{id}/edit',[PostController::class,'edit'])->name('posts.edit');
    Route::post('posts/{id}',[PostController::class,'update'])->name('posts.update');
    Route::get('posts/{id}',[PostController::class,'destroy'])->name('posts.destroy');
    
    Route::get('categories',[CategoryController::class,'index'])->name('categories.index');
    Route::get('categories/create',[CategoryController::class,'create'])->name('categories.create');
    Route::post('categories/',[CategoryController::class,'store'])->name('categories.store');
    Route::get('categories/{id}/edit',[CategoryController::class,'edit'])->name('categories.edit');
    Route::post('categories/{id}',[CategoryController::class,'update'])->name('categories.update');
    Route::get('categories/{id}',[CategoryController::class,'destroy'])->name('categories.destroy');
    
});

require __DIR__.'/auth.php';
