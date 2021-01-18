<?php

use App\EventUser;
use App\User;
use Illuminate\Database\Seeder;

class EventUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(EventUser::class, 80)
            ->create();
    }
}
