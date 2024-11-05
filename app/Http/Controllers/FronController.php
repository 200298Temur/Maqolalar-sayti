<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class FronController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::where('publish', '1')->orderBy('created_at', 'desc')->get();
        $categories = Category::orderBy('name', 'desc')->get();
        // dd($categories);
        return view('front.post.index', [
            'posts' => $posts,
            'categories' => $categories // Bu bilan main.blade.php ga ham uzatiladi
        ]);
    }
    public function show(string $id)
    {   
        $posts = Post::where('publish', '1')
                 ->where('id', '=', $id)
                 ->orderBy('created_at', 'desc')
                 ->get();
        $categories = Category::orderBy('name', 'desc')->get();
        // dd($categories);
        return view('front.post.index', [
            'posts' => $posts,
            'categories' => $categories // Bu bilan main.blade.php ga ham uzatiladi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
