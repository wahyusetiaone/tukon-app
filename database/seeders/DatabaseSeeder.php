<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{

    protected $toTruncate = ['roles', 'kode_statuses','plan_progress'];

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        foreach($this->toTruncate as $table) {
            DB::table($table)->truncate();
        }
        $this->call(RoleSeeder::class);
        $this->call(KodeStatusSeeder::class);
        $this->call(BPASeeder::class);
        $this->call(LimitasiPenarikanSeeder::class);
        $this->call(PersentasePenarikanSeeder::class);

        Model::reguard();

    }
}
