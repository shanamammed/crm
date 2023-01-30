<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
          $permissions = [
           'role-list',
           'role-create',
           'role-edit',
           'role-delete',
           'user-list',
           'user-create',
           'user-edit',
           'user-delete',
           'deal-list',
           'deal-create',
           'deal-edit',
           'deal-delete',
           'activity-list',
           'activity-create',
           'activity-edit',
           'activity-delete',
           'contact-list',
           'contact-create',
           'contact-edit',
           'contact-delete',
           'products-list',
           'products-create',
           'products-edit',
           'products-delete',
           'company-list',
           'company-create',
           'company-edit',
           'company-delete',
           'setting-list',
           'setting-create',
           'setting-edit',
           'setting-delete',
           'document-list',
           'document-create',
           'document-edit',
           'document-delete',
           'calendar-list',
           'calendar-create',
           'calendar-edit',
           'calendar-delete',
        ];
     
        foreach ($permissions as $permission) {
             Permission::create(['name' => $permission]);
        }
    }
}
