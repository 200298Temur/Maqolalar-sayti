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

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3'
        ]);
    
        if ($validator->passes()) {
            $role = Role::create(['name' => $request->name]);
    
            // Attach permissions using IDs
            if (!empty($request->permission)) {
                $role->permissions()->attach($request->permission);
            }
    
            return redirect()->route('roles.index')->with('success', 'Role added successfully.');
        } else {
            return redirect()->route('roles.create')->withInput()->withErrors($validator);
        }
    }
    
    

    public function edit($id) {
        $role = Role::find($id);
        $permissions = Permission::all();
        $hasPermissions = $role->permissions->pluck('id'); // Only IDs
    
        return view('role.edit', compact('role', 'permissions', 'hasPermissions'));
    }
    
   
    public function update(Request $request, string $id) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3'
        ]);
    
        $role = Role::find($id);
    
        if ($validator->passes()) {
            $role->name = $request->name;
            $role->save();
    
            // Sync the permissions using IDs
            $role->permissions()->sync($request->permission ?? []);
        }
        return redirect()->route('roles.index');
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
