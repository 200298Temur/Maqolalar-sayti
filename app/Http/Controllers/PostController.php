<?php

namespace App\Http\Controllers;

use App\Models\Category;
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
    public function show(string $id){
        $post=Post::find($id);
        return view('post.show',[
            'post'=>$post
        ]);
    }
    public function create(Request $request){
        $categories=Category::orderBy('name','asc')->get();
        return view('post.create',[
            'categories'=>$categories
        ]);
    }
    public function store(Request $request)
    {
        // Validate the input
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'subtitle' => 'required|min:5',
            'content' => 'required|min:10',
            // 'categories' => 'array' // categories maydonini array qilib ko'rsatilganini tekshiradi
        ]);
    
        if ($validator->passes()) {
            $post = new Post();
            $post->title = $request->title;
            $post->subtitle = $request->subtitle;
            $post->content = $request->content;
            $post->author_id = auth()->user()->id;
            $post->save();
    
            // dd($request->categories);
            if (!empty($request->categories)) {
                $post->categories()->attach($request->categories);
            }
            
    
            return redirect()->route('posts.index')->with('success', 'Post created successfully');
        } else {
            return redirect()->route('posts.create')->withInput()->withErrors($validator);
        }
    }
    

    public function destroy(Request $request){
        $post=Post::find($request->id);
        if($post==null){
            return redirect()->route('posts.index')->with('error', 'Post not found');

        }
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post deleted successfully');
    }

    public function edit(string $id){
        $post=Post::find($id);
        $categories=Category::orderBy('name','asc')->get();
        $hasCategories=$post->categories->pluck('name');
        return view('post.edit',[
            'post'=>$post,
            'categories'=>$categories,
            'hasCategories'=>$hasCategories
        ]);
    }

    public function update(Request $request,string $id){
        $post =Post::find($id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'subtitle' => 'required|min:5',
            'content' => 'required|min:10',
        ]);
        if ($validator->passes()) {
            $post->title = $request->title;
            $post->subtitle = $request->subtitle;
            $post->content = $request->content;
            $post->author_id = auth()->user()->id;
            // dd($post);
            $post->save();
            if(!empty($request->categories)){
                // $post->syncCategories($request->categories);
                $post->categories()->sync($request->categories);
            }else{
                $post->categories()->sync();
            }
            return redirect()->route('posts.index')->with('success', 'Post updated successfully');
        } else {
            // Redirect back to create page with errors
            return redirect()->route('posts.create')->withInput()->withErrors($validator);
        }
    }

    public function uploadMedia(Request $request)
    {
        return "Salom";
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
      
            $request->file('upload')->move(public_path('media'), $fileName);
      
            $url = asset('media/' . $fileName);
  
            return response()->json(['fileName' => $fileName, 'uploaded'=> 1, 'url' => $url]);
        }
    }
}
