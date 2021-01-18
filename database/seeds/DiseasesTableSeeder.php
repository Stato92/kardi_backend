<?php

use App\Disease;
use Illuminate\Database\Seeder;

class DiseasesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Disease::create([
            'name' => 'choroba niedokrwienna serca',
        ]);
        Disease::create([
            'name' => 'zaburzenia rytmu serca',
        ]);
        Disease::create([
            'name' => 'przewlekła niewydolność serca',
        ]);
        Disease::create([
            'name' => 'nadciśnienie tętnicze',
        ]);
        Disease::create([
            'name' => 'udar mózgu',
        ]);
        Disease::create([
            'name' => 'zawał serca',
        ]);
        Disease::create([
            'name' => 'rozwarstwienie aorty piersiowej',
        ]);
        Disease::create([
            'name' => 'tętniak aorty piersiowej',
        ]);
        Disease::create([
            'name' => 'tętniak aorty brzusznej',
        ]);
    }
}
