<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index() {
        $posts = Post::with('author')->latest()->paginate(10); // 'author.name' o'rniga faqat 'author' ni qo'llang
        return view('post.list', [
            'posts' => $posts
        ]);
    }
    
    

    public function create(Request $request){
        return view('post.create');
    }
    public function store(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'subtitle' => 'required|min:5',
            'content' => 'required|min:10',
        ]);
    
        // dd($validator);
        // Check if validation passes
        if ($validator->passes()) {
            $post = new Post();
            $post->title = $request->title;
            $post->subtitle = $request->subtitle;
            $post->content = $request->content;
            $post->author_id = auth()->user()->id;
            // dd($post);
            $post->save();

            return redirect()->route('posts.index')->with('success', 'Post created successfully');
        } else {
            // Redirect back to create page with errors
            return redirect()->route('posts.create')->withInput()->withErrors($validator);
        }
    }

}
