<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Venue;

class VenueSeeder extends Seeder
{
    public function run(): void
    {
        $venues = [
            [
                'name' => 'Jakarta Convention Center',
                'address' => 'Jl. Gatot Subroto, Jakarta',
                'city' => 'Jakarta',
                'capacity' => 5000,
            ],
            [
                'name' => 'Gran Melia Hotel',
                'address' => 'Jl. Sudirman, Jakarta',
                'city' => 'Jakarta',
                'capacity' => 800,
            ],
            [
                'name' => 'Art Space Studio',
                'address' => 'Jl. Kemang, Jakarta',
                'city' => 'Jakarta',
                'capacity' => 300,
            ],
            [
                'name' => 'Monas Bundaran',
                'address' => 'Lapangan Monas, Jakarta',
                'city' => 'Jakarta',
                'capacity' => 10000,
            ],
        ];

        foreach ($venues as $venue) {
            Venue::firstOrCreate(['name' => $venue['name']], $venue);
        }
    }
}
