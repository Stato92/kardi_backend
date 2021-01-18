<?php

use App\StatusComment;
use Illuminate\Database\Seeder;

class StatusCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(StatusComment::class, 80)
            ->create();
    }
}
