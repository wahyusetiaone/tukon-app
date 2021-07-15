<?php

namespace Database\Seeders;

use App\Models\PlanProgress;
use Illuminate\Database\Seeder;

class PlanProgressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pln = new PlanProgress();
        $pln->nama_plan_progress='planning';
        $pln->save();

        $pln1 = new PlanProgress();
        $pln1->nama_plan_progress='preparing';
        $pln1->save();

        $pln2 = new PlanProgress();
        $pln2->nama_plan_progress='building';
        $pln2->save();

        $pln3 = new PlanProgress();
        $pln3->nama_plan_progress='finishing';
        $pln3->save();

        $pln4 = new PlanProgress();
        $pln4->nama_plan_progress='evaluating';
        $pln4->save();
    }
}
