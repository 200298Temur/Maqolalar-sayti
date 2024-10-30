<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(){
        $posts=Post::latest(10);
        return view('post.list',[
            'posts'=>$posts
        ]);
    }

    public function create(Request $request){
        return view('post.create');
    }
    public function store(Request $request){
        return 'done';
    }
}
