<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    public function index(){
        $permissions=Permission::orderBy('id','asc')->get();
        return view('permission.list',[
            'permissions'=>$permissions
        ]);
    }
}
