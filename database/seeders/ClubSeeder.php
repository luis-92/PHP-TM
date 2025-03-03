<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Club;

class ClubSeeder extends Seeder
{
    public function run()
    {
        Club::create([
            'name' => 'Toastmasters Innovadores',
            'description' => 'Club de oratoria y liderazgo.',
            'location' => 'Ciudad de México',
            'meeting_schedule' => 'Todos los miércoles a las 7 PM',
        ]);
    }
}
