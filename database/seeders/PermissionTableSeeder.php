<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = array(
            array(
                'slug' => 'role-list',
                'name' => 'List Roles'
            ),
            array(
                'slug' => 'role-create',
                'name' => 'Create Roles'
            ),
            array(
                'slug' => 'role-edit',
                'name' => 'Edit Roles'
            ),
            array(
                'slug' => 'role-delete',
                'name' => 'Delete Roles'
            ),
            array(
                'slug' => 'user-list',
                'name' => 'List Users'
            ),
            array(
                'slug' => 'user-create',
                'name' => 'Create User'
            ),
            array(
                'slug' => 'user-edit',
                'name' => 'Edit User'
            ),
            array(
                'slug' => 'user-delete',
                'name' => 'Delete User'
            ),
            array(
                'slug' => 'deal-list',
                'name' => 'List deals'
            ),
            array(
                'slug' => 'deal-create',
                'name' => 'Create deals'
            ),
            array(
                'slug' => 'deal-edit',
                'name' => 'Edit deals'
            ),
            array(
                'slug' => 'deal-delete',
                'name' => 'Delete deals'
            ),
            array(
                'slug' => 'activity-list',
                'name' => 'List activities'
            ),
            array(
                'slug' => 'activity-create',
                'name' => 'Create activities'
            ),
            array(
                'slug' => 'activity-edit',
                'name' => 'Edit activities'
            ),
            array(
                'slug' => 'activity-delete',
                'name' => 'Delete activities'
            ),
            array(
                'slug' => 'company-list',
                'name' => 'List company'
            ),
            array(
                'slug' => 'company-create',
                'name' => 'Create company'
            ),
            array(
                'slug' => 'company-edit',
                'name' => 'Edit company'
            ),
            array(
                'slug' => 'company-delete',
                'name' => 'Delete company'
            ),
            array(
                'slug' => 'setting-list',
                'name' => 'List settings'
            ),
            array(
                'slug' => 'setting-create',
                'name' => 'Create settings'
            ),
            array(
                'slug' => 'setting-edit',
                'name' => 'Edit settings'
            ),
            array(
                'slug' => 'setting-delete',
                'name' => 'Delete settings'
            ),
            array(
                'slug' => 'calendar-list',
                'name' => 'List calendar'
            ),
            array(
                'slug' => 'calendar-create',
                'name' => 'Create calendar'
            ),
            array(
                'slug' => 'calendar-edit',
                'name' => 'Edit calendar'
            ),
            array(
                'slug' => 'calendar-delete',
                'name' => 'Delete calendar'
            ),
            array(
                'slug' => 'contact-list',
                'name' => 'List contacts'
            ),
            array(
                'slug' => 'contact-create',
                'name' => 'Create contacts'
            ),
            array(
                'slug' => 'contact-edit',
                'name' => 'Edit contacts'
            ),
            array(
                'slug' => 'contact-delete',
                'name' => 'Delete contacts'
            ),
            array(
                'slug' => 'document-list',
                'name' => 'List documents'
            ),
            array(
                'slug' => 'document-create',
                'name' => 'Create documents'
            ),
            array(
                'slug' => 'document-edit',
                'name' => 'Edit documents'
            ),
            array(
                'slug' => 'document-delete',
                'name' => 'Delete documents'
            ),
        );
        DB::table('permissions')->insert($array);

      
    }
}
