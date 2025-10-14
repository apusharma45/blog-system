<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['name' => 'Administrator', 'slug' => 'admin'],
            ['name' => 'Editor', 'slug' => 'editor'],
            ['name' => 'Author', 'slug' => 'author'],
            ['name' => 'User', 'slug' => 'user'],
        ];

        $permissions = [
            ['name' => 'Manage Users', 'slug' => 'manage-users'],
            ['name' => 'Manage Posts', 'slug' => 'manage-posts'],
            ['name' => 'Publish Posts', 'slug' => 'publish-posts'],
            ['name' => 'Edit Any Post', 'slug' => 'edit-any-post'],
        ];

        foreach ($roles as $data) {
            Role::firstOrCreate(['slug' => $data['slug']], $data);
        }

        foreach ($permissions as $data) {
            Permission::firstOrCreate(['slug' => $data['slug']], $data);
        }

        $admin = Role::where('slug', 'admin')->first();
        $editor = Role::where('slug', 'editor')->first();

        $manageUsers = Permission::where('slug', 'manage-users')->first();
        $managePosts = Permission::where('slug', 'manage-posts')->first();
        $publishPosts = Permission::where('slug', 'publish-posts')->first();
        $editAnyPost = Permission::where('slug', 'edit-any-post')->first();

        if ($admin) {
            $admin->permissions()->syncWithoutDetaching([
                $manageUsers->id,
                $managePosts->id,
                $publishPosts->id,
                $editAnyPost->id,
            ]);
        }

        if ($editor) {
            $editor->permissions()->syncWithoutDetaching([
                $managePosts->id,
                $publishPosts->id,
            ]);
        }

        // Attach admin role to first user (if exists)
        if ($firstUser = User::first()) {
            $firstUser->roles()->syncWithoutDetaching([$admin->id]);
        }
    }
}
