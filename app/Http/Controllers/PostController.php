<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index() {
        $posts = Post::where('lang',app()->getLocale())->with('author')->latest()->paginate(10); // 'author.name' o'rniga faqat 'author' ni qo'llang
        return view('post.list', [
            'posts' => $posts
        ]);
    }
    public function search(Request $request)
    {
        $search = $request->input('search');
        
        $posts = Post::where('title', 'like', "%$search%")
                    ->orWhere('subtitle', 'like', "%$search%")
                    ->orWhere('content', 'like', "%$search%")
                    ->with('author')
                    ->latest()
                    ->paginate(10); // Sahifada 10 ta post ko'rsatish

        return view('post.list', ['posts' => $posts,'search'=>$search]);
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
        // dd($request);
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:3',
            'subtitle' => 'required|min:5',
            'content' => 'required|min:10',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();
        if($request->has('image')){
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();

            $filename=time().'.'.$extension;

            $path='uploads/posts/';
            $file->move($path,$filename); 
            $post->image=$path.$filename;
        }
        
        // Creating a new Post instance
        $post->title = $request->title;
        $post->subtitle = $request->subtitle;
        $post->content = $request->content;
        $post->lang = $request->lang;
        $post->publish = $request->publish === 'publish' ? 1 : 0;
        $post->Attime = $request->Attime ? \Carbon\Carbon::parse($request->Attime)->format('Y-m-d') : now()->format('Y-m-d');
        $post->author_id = auth()->user()->id;
        $post->save();

        // Attaching categories if available
        if ($request->has('categories')) {
            $post->categories()->attach($request->categories);
        }

        return redirect()->route('post.index')->with('success', 'Post created successfully');
    }

    

    
    
    public function destroy(Request $request){
        $post=Post::find($request->id);
        if($post==null){
            return redirect()->route('post.index')->with('error', 'Post not found');

        }
        $post->delete();
        return redirect()->route('post.index')->with('success', 'Post deleted successfully');
    }

    public function edit(string $id){
        $post = Post::find($id);
        // dd($id);
        if (!$post) {
            // Handle the case where the post is not found (e.g., redirect or show a message)
            return redirect()->route('post.index')->with('error', 'Post not found');
        }
    
        $categories = Category::orderBy('name', 'asc')->get();
        $hasCategories = $post->categories->pluck('name');
    
        return view('post.edit', [
            'post' => $post,
            'categories' => $categories,
            'hasCategories' => $hasCategories,
            'locale' => app()->getLocale()
        ]);
    }
    

    public function update(Request $request,string $id){
        $post =Post::find($id);
        // dd($request);
        $validator = Validator::make($request->all(), [
            'title' => 'required|min:5',
            'subtitle' => 'required|min:5',
            'content' => 'required|min:10',
        ]);

        if($request->has('image')){
            $file=$request->file('image');
            $extension=$file->getClientOriginalExtension();

            $filename=time().'.'.$extension;

            $path='uploads/posts/';
            $file->move($path,$filename); 
            $post->image=$path.$filename;
        }
        if ($validator->passes()) {
            $post->title = $request->title;
            $post->subtitle = $request->subtitle;
            $post->content = $request->content;
            $post->lang = $request->lang;
            $post->publish = $request->publish === 'publish' ? 1 : 0;
            $post->Attime = $request->Attime ? \Carbon\Carbon::parse($request->Attime)->format('Y-m-d') : now()->format('Y-m-d');    
            $post->author_id = auth()->user()->id;
            // dd($post);
            $post->save();
            if(!empty($request->categories)){
                // $post->syncCategories($request->categories);
                $post->categories()->sync($request->categories);
            }else{
                $post->categories()->sync();
            }
            return redirect()->route('post.index')->with('success', 'Post updated successfully');
        } else {
            // Redirect back to create page with errors
            return redirect()->route('post.create')->withInput()->withErrors($validator);
        }
    }
    public function upload(Request $request)
    {
        try {
            // Faylni tekshirish
            $request->validate([
                'upload' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            ]);
            $folder = storage_path('app/public/images/');
            if (!is_dir($folder)) {
                mkdir($folder, 777);
            }
            $file = $request->file('upload');
            $file_name = time() . $file->getClientOriginalName();
            $repeat = 0;
            if (is_file($file_name)) {
                $repeat++;
                $file_name = $repeat . "_" . $file_name;
            }
            $path = $file->move($folder, $file_name);
            $url = env('APP_URL') . "/storage/images/" . $file_name;

            return response()->json([
                'uploaded' => true,
                'url' => $url
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'uploaded' => false,
                'error' => [
                    'message' => $e->getMessage()
                ]
            ]);
        }
    }

}
