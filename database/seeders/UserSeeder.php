<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default credentials
        $user = User::insert([
            [ 
                'name' => 'Admin',
                'email' => 'admin@crm.bh',
                'email_verified_at' => now(),
                'role_id' => '1',
                'password' => bcrypt('admin@crm'), 
                'gender' => 'male',
                'active' => 1,
                'remember_token' => Str::random(10)
            ]
        ]);
        
         // Fake users
        User::factory()->times(9)->create();

        $role = Role::create(['name' => 'Admin']);
     
        $permissions = Permission::pluck('id','id')->all();
   
        $role->syncPermissions($permissions);
     
        $user->assignRole([$role->id]);
    }
}
