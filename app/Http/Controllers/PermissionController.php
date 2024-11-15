<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    public function index(){
        $permissions=Permission::orderBy('id','asc')->get();
        return view('permission.list',[
            'permissions'=>$permissions
        ]);
    }
    public function create(){
        return view('permission.create');
    }
    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:5',
            'key'=>'required|min:3'
        ]);
        if($validator->passes()){
            $permission=new Permission();
            $permission->name=$request->name;
            $permission->key=$request->key;
            $permission->save();
            return redirect()->route('permission.index')->with('success','Permission created successfully!');
        }else{
            return redirect()->route('permission.index')->withInput()->withErrors($validator);
        }
    }

    public function edit(string $id){
        $permission=Permission::find($id);
        return view('permission.edit',[
            'permission'=>$permission
        ]);
    }

    public function update(Request $request,string $id){
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:5',
            'key'=>'required|min:3'
        ]);
        
        if($validator->passes()){
            $permission=Permission::find($id);
            $permission->name=$request->name;
            $permission->key=$request->key;
            $permission->save();
            return redirect()->route('permission.index')->with('success','Permission updated successfully!');
        }else{
            return redirect()->route('permission.index')->withInput()->withErrors($validator);
        }
    }
    public function destroy(string $id){
        $per=Permission::find($id);
        if($per==null){
            return redirect()->route('permission.index')->with('error', 'Permission not found');

        }
        $per->delete();
        return redirect()->route('permission.index')->with('success', 'Permission deleted successfully');
    
    }
}
