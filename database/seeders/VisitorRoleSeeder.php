<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class VisitorRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $visitorPermissions = [
           'address-list',
           'address-create',
           'address-inisiate-default',
           'address-send-mail-before-delete',
           'user-list'
        ];

        $role = Role::create([
            'name' => 'Visitor'
        ]);

        $role->syncPermissions($visitorPermissions);
    }
}
