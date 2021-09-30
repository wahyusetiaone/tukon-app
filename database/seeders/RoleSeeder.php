<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $role = new Roles();
        $role->nama_role='superadmin';
        $role->save();

        $role1 = new Roles();
        $role1->nama_role='tukang';
        $role1->save();

        $role2 = new Roles();
        $role2->nama_role='klien';
        $role2->save();

        $role = new Roles();
        $role->nama_role='admin';
        $role->save();
    }
}
