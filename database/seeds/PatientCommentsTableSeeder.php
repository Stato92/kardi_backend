<?php

use App\PatientComment;
use Illuminate\Database\Seeder;

class PatientCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(PatientComment::class, 200)
            ->create();
    }
}
