<?php

namespace Database\Seeders;

use App\Models\Limitasi_Penarikan;
use Illuminate\Database\Seeder;

class LimitasiPenarikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $limitasi = new Limitasi_Penarikan();
        $limitasi->value=50;
        $limitasi->name='Limitasi 50%';
        $limitasi->save();

        $limitasi1 = new Limitasi_Penarikan();
        $limitasi1->value=100;
        $limitasi1->name='Pembayaran Penuh';
        $limitasi1->save();
    }
}
