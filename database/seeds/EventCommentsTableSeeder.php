<?php

use App\EventComment;
use Illuminate\Database\Seeder;

class EventCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EventComment::class, 100)
            ->create();
    }
}
