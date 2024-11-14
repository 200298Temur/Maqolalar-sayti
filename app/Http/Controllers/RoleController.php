<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function index(){
        $roles=Role::orderBy('name','asc')->get();
        // dd($roles);
        return view('role.list',[
            'roles'=>$roles
        ]);
    }

    public function create(Request $request){
        $permissions=Permission::orderBy('id','asc')->get();
        return view('role.create',[
            'permissions'=>$permissions
        ]);
    }

    public function store(Request $request){
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3'
        ]);
        if ($validator->passes()) {
            $role=Role::create(['name' => $request->name]);
            if(!empty($request->permission)){
                if ($request->has('permissions')) {
                    $role->permissions()->attach($request->permissions);
                }
            }


            return redirect()->route('roles.index')->with('success', 'Roles added successfully.');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
        
    }

    public function edit(string $id){
        $role=Role::find($id);
        $permissions=Permission::orderBy('id','asc')->get();
        $hasPermissions=$role->permissions->pluck('name');
        return view('role.edit',[
            'role'=>$role,
            'permissions'=>$permissions,
            'hasPermissions'=>$hasPermissions
        ]);
    }

    public function update(Request $request,string $id){
        $validator=Validator::make($request->all(),[
            'name'=>'required|min:3'
        ]);
        $role=Role::find($id);
        if($validator->passes()){
            $role->name=$request->name;
            $role->save();
            if(!empty($request->permissions)){
                $role->permissions()->sync($request->permissions);
            }else{
                $role->permissions()->sync();
            }
        }
    }

    public function  destroy(string $id)  {
        $post=Role::find($id);
        if($post==null){
            return redirect()->route('roles.index')->with('error', 'Role not found');

        }
        $post->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully');
    

    }
}
