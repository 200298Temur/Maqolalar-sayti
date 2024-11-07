<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use function PHPUnit\Framework\returnSelf;

class CategoryController extends Controller
{
    public function index(){
        $categories=Category::latest()->paginate(20);
        return view('category.list',[
            'categories'=>$categories
        ]);
    }

    public function create(){
        return view('category.create');
    }

    public  function store(Request $request){
        // dd($request);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'lang' => 'required',
        ]);
        // dd($validator);
        if ($validator->passes()) {
            $post = new Category();
            $post->name = $request->name;
            $post->lang = $request->lang;
            
            $post->save();

            return redirect()->route('categories.index')->with('success', 'Category created successfully');
        } else {
            return redirect()->route('categories.create')->withInput()->withErrors($validator);
        }
    }

    public function edit(string $id){
        $category=Category::find($id);
        return view('category.edit',[
            'category'=>$category
        ]);
    }

    public  function update(Request $request,string $id){
        
        $post =Category::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
        ]);
    
        if ($validator->passes()) {
            $post->name = $request->name;
            $post->lang= $request->lang;
            
            $post->save();

            return redirect()->route('categories.index')->with('success', 'Category updated successfully');
        } else {
            return redirect()->route('categories.edit')->withInput()->withErrors($validator);
        }
    }
    public function destroy(string $id){
        $category=Category::find($id);
        // dd($category);
        if($category==null){
            session()->flash('error','Category not found');
            
            return  redirect()->route('categories.index')->with('error', 'Category not found');;
        }

        $category->delete();
        
        return  redirect()->route('categories.index')->with('success', 'Category deleted successfully');;

    }
}
