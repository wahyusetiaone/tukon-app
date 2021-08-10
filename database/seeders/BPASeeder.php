<?php

namespace Database\Seeders;

use App\Models\BPA;
use Illuminate\Database\Seeder;

class BPASeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bpa = new BPA();
        $bpa->bpa = 2;
        $bpa->save();
    }
}
