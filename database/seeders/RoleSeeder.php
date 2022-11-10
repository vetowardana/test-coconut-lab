<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::where('email', 'coconutlab.adm@gmail.com')->first();

        $role = Role::create([
            'name' => 'Super Admin'
        ]);

        $user->assignRole([$role->id]);
    }
}
