<?php

namespace Database\Seeders;

use App\Models\Persentase_Penarikan;
use Illuminate\Database\Seeder;

class PersentasePenarikanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $presen = new Persentase_Penarikan();
        $presen->value=5;
        $presen->name='Penarikan 5%';
        $presen->save();

        $presen1 = new Persentase_Penarikan();
        $presen1->value=10;
        $presen1->name='Penarikan 10%';
        $presen1->save();

        $presen2 = new Persentase_Penarikan();
        $presen2->value=15;
        $presen2->name='Penarikan 15%';
        $presen2->save();

        $presen3 = new Persentase_Penarikan();
        $presen3->value=20;
        $presen3->name='Penarikan 20%';
        $presen3->save();

        $presen4 = new Persentase_Penarikan();
        $presen4->value=25;
        $presen4->name='Penarikan 25%';
        $presen4->save();

        $presen5 = new Persentase_Penarikan();
        $presen5->value=100;
        $presen5->name='Penarikan 100%';
        $presen5->save();
    }
}
