<?php

namespace Database\Seeders;

use App\Models\BACabang;
use Illuminate\Database\Seeder;

class BACSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bac = new BACabang();
        $bac->bac = 2;
        $bac->save();
    }
}
