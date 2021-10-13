<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Admin();
        $admin->id = 0;
        $admin->nomor_telepon = '081882881286';
        $admin->alamat = 'Admin Pusat';
        $admin->provinsi = 'Admin Pusat';
        $admin->kota = 'Admin Pusat';
        $admin->kode_lokasi = '{lat:0, lang:0}';
        $admin->path_foto = 'storage/images/photos/def_profile.svg';
        $admin->save();
    }
}
