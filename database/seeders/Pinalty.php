<?php

namespace Database\Seeders;

use App\Models\Penalty;
use Illuminate\Database\Seeder;

class Pinalty extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $penalty = new Penalty();
        $penalty->value = 20;
        $penalty->active = true;
    }
}
