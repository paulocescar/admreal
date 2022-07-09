<?php

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\Permission_user;
use Illuminate\Support\Facades\DB;

class seedPermissionTest extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $owner = new Role();
        // $owner->name         = 'owner';
        // $owner->display_name = 'Project Owner'; // optional
        // $owner->description  = 'User is the owner of a given project'; // optional
        // $owner->save();

        // $admin = new Role();
        // $admin->name         = 'admin';
        // $admin->display_name = 'User Administrator'; // optional
        // $admin->description  = 'User is allowed to manage and edit other users'; // optional
        // $admin->save();

        // $createPost = new Permission();
        // $createPost->name         = 'View teams';
        // $createPost->display_name = 'View teams table'; // optional
        // // Allow a user to...
        // $createPost->description  = 'Permission to view teams table'; // optional
        // $createPost->save();

        // $editUser = new Permission();
        // $editUser->name         = 'edit-teams';
        // $editUser->display_name = 'Edit teams'; // optional
        // // Allow a user to...
        // $editUser->description  = 'edit existing teams'; // optional
        // $editUser->save();

        // DB::table('permission_user')->insert([
        //     "permission_id" => 1,
        //     "user_id" => 1,
        //     "user_type" => "App\Models\User"
        // ]);
        DB::table('permission_user')->insert([
            "permission_id" => 2,
            "user_id" => 1,
            "user_type" => "App\Models\User"
        ]);
    }
}
