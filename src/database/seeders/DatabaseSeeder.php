<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            VenueSeeder::class,
            EventSeeder::class,
            TicketTypeSeeder::class,
            UserSeeder::class,
            BookingSeeder::class,
        ]);
    }
}
