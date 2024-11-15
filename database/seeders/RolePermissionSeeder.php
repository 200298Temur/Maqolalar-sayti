<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('name', 'ADMIN')->first();

        $role_view = Permission::where('key', 'role_view')->first();
        $role_create = Permission::where('key', 'role_create')->first();
        $role_update = Permission::where('key', 'role_update')->first();
        $role_delete = Permission::where('key', 'role_delete')->first();
        $post_view = Permission::where('key', 'post_view')->first();
        $post_create = Permission::where('key', 'post_create')->first();
        $post_update = Permission::where('key', 'post_update')->first();
        $post_delete = Permission::where('key', 'post_delete')->first();
        $category_view = Permission::where('key', 'category_view')->first();
        $category_create = Permission::where('key', 'category_create')->first();
        $category_update = Permission::where('key', 'category_update')->first();
        $category_delete = Permission::where('key', 'category_delete')->first();
        $user_view = Permission::where('key', 'user_view')->first();
        $user_create = Permission::where('key', 'user_create')->first();
        $user_update = Permission::where('key', 'user_update')->first();
        $user_delete = Permission::where('key', 'user_delete')->first();
        $role_edit=Permission::where('key','role_edit')->first();
        $role_store=Permission::where('key','role_store')->first();
        $post_edit=Permission::where('key','post_edit')->first();
        $post_store=Permission::where('key','post_store')->first();
        $category_edit=Permission::where('key','category_edit')->first();
        $category_store=Permission::where('key','category_store')->first();
        $user_edit=Permission::where('key','user_edit')->first();
        $user_store=Permission::where('key','user_store')->first();

        $adminRole->permissions()->attach([
            $role_view->id,
            $role_create->id,
            $role_update->id,
            $role_edit->id,
            $role_store->id,
            $role_delete->id,

            $post_view->id,
            $post_create->id,
            $post_update->id,
            $post_delete->id,
            $post_edit->id,
            $post_store->id,
            $category_view->id,
            $category_create->id,
            $category_update->id,
            $category_delete->id,
            $category_edit->id,
            $category_store->id,
            $user_view->id,
            $user_create->id,
            $user_update->id,
            $user_delete->id,
            $user_edit->id,
            $user_store->id,
        ]);
    }
}
