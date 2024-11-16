<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $permissions = $user->permissions();
        $currentRouteName = Route::currentRouteName();

        $baseRoute = Str::before($currentRouteName, '.');
        $permissionKeys = $permissions->pluck('key')->toArray();
        
        // dd(in_array('category_edit', auth()->user()->permissions()->toArray()),
        // in_array($baseRoute.'_edit', $permissionKeys),$baseRoute.'_edit');
        // dd(auth()->user()->permissions()->contains('category_edit'),$baseRoute.'_edit');

        if ($this->check($currentRouteName)){
            if (Str::endsWith($currentRouteName, 'index') && in_array($baseRoute.'_view', $permissionKeys)) {
                return $next($request);
            }elseif (Str::endsWith($currentRouteName, 'create') && in_array($baseRoute.'_create', $permissionKeys)) {
                return $next($request);
            }elseif(Str::endsWith($currentRouteName, 'edit') && in_array($baseRoute.'_edit', $permissionKeys)) {
                return $next($request);
            }elseif(Str::endsWith($currentRouteName, 'destroy') && in_array($baseRoute.'_delete', $permissionKeys)) {
                return $next($request);
            }elseif(Str::endsWith($currentRouteName, 'store') && in_array($baseRoute.'_store', $permissionKeys)) {
                return $next($request);
            }elseif(Str::endsWith($currentRouteName, 'update') && in_array($baseRoute.'_update', $permissionKeys)) {
                return $next($request);
            }
            else{
                abort(403); 
            }
        }
        
        return $next($request);
    }

    public function check(string $currentRouteName){
        if(Str::startsWith($currentRouteName, 'post')){
            return true;
        }elseif(Str::startsWith($currentRouteName, 'role')){
            return true;
        }elseif(Str::startsWith($currentRouteName, 'user')){
            return true;
        }elseif(Str::startsWith($currentRouteName, 'categoriy')){
            return true;
        }else{
            return false;
        }        
    }
}