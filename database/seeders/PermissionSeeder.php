<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name'=>'View Roles','key'=>'role_view']);
        Permission::create(['name'=>'Create Roles','key'=>'role_create']);
        Permission::create(['name'=>'Update Role','key'=>'role_update']);
        Permission::create(['name'=>'Delete Role','key'=>'role_delete']);
        Permission::create(['name'=>'View Post','key'=>'post_view']);
        Permission::create(['name'=>'Create Post','key'=>'post_create']);
        Permission::create(['name'=>'Update Post','key'=>'post_update']);
        Permission::create(['name'=>'Delete Post','key'=>'post_delete']);
        Permission::create(['name'=>'View Category','key'=>'category_view']);
        Permission::create(['name'=>'Create Category','key'=>'category_create']);
        Permission::create(['name'=>'Update Category','key'=>'category_update']);
        Permission::create(['name'=>'Delete Category','key'=>'category_delete']);
        Permission::create(['name'=>'View User','key'=>'user_view']);
        Permission::create(['name'=>'Create User','key'=>'user_create']);
        Permission::create(['name'=>'Update User','key'=>'user_update']);
        Permission::create(['name'=>'Delete User','key'=>'user_delete']);

        
    }
}
