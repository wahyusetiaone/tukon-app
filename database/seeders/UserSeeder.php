<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new User();
        $admin->id = 0;
        $admin->google_id = '000000000000000000000000000000';
        $admin->name = 'Superadmin';
        $admin->email = 'wahyusetiaone27@gmail.com';
        $admin->email_verified_at = now();
        $admin->no_hp = '081882881286';
        $admin->no_hp_verified_at = now();
        $admin->password = '$2y$10$FmANfVYv5L8I6jDW9nBGFelyRWDgUBCytTsFIlKIp55/4N.K9yC.W';
        $admin->kode_role = 1;
        $admin->kode_user = 0;
        $admin->save();
    }
}
