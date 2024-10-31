<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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

    }

    public  function store(){

    }
    public function edit(){

    }

    public  function update(){

    }
    public function destroy(){

    }
}
