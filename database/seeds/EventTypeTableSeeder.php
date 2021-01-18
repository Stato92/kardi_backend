<?php

use App\EventType;
use Illuminate\Database\Seeder;

class EventTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        EventType::create([
            'name' => 'e-Peticoat'
        ]);
        EventType::create([
            'name' => 'Debranching'
        ]);
        EventType::create([
            'name' => 'PMG-3D'
        ]);
        EventType::create([
            'name' => 'FEVAR'
        ]);
        EventType::create([
            'name' => 'TEVAR'
        ]);
        EventType::create([
            'name' => 'Tomografia kontrolna'
        ]);
        EventType::create([
            'name' => 'Wizyta'
        ]);
    }
}
