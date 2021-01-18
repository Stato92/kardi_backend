<?php

use App\Alert;
use Illuminate\Database\Seeder;

class AlertsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Alert::class, 80)
            ->create();
    }
}
