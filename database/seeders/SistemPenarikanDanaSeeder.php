<?php

namespace Database\Seeders;

use App\Models\Sistem_Penarikan_Dana;
use Illuminate\Database\Seeder;

class SistemPenarikanDanaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role = new Sistem_Penarikan_Dana();
        $role->nama='Tiap Progress Proyek';
        $role->save();

        $role = new Sistem_Penarikan_Dana();
        $role->nama='Selesai Proyek';
        $role->save();
    }
}
