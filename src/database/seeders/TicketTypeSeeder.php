<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TicketType;
use App\Models\Event;

class TicketTypeSeeder extends Seeder
{
    public function run(): void
    {
        $ticketConfigs = [
            [
                'event_slug' => 'konser-musik-elektro-2026',
                'types' => [
                    ['name' => 'Regular', 'price' => 350000, 'quota' => 500],
                    ['name' => 'VIP', 'price' => 500000, 'quota' => 250],
                    ['name' => 'VVIP', 'price' => 750000, 'quota' => 100],
                ],
            ],
            [
                'event_slug' => 'seminar-digital-marketing',
                'types' => [
                    ['name' => 'Early Bird', 'price' => 250000, 'quota' => 100],
                    ['name' => 'Regular', 'price' => 350000, 'quota' => 300],
                    ['name' => 'VIP', 'price' => 500000, 'quota' => 100],
                ],
            ],
            [
                'event_slug' => 'workshop-fotografi',
                'types' => [
                    ['name' => 'Regular', 'price' => 200000, 'quota' => 50],
                    ['name' => 'Premium', 'price' => 300000, 'quota' => 30],
                ],
            ],
            [
                'event_slug' => 'pertandingan-basket-pro',
                'types' => [
                    ['name' => 'Umum', 'price' => 150000, 'quota' => 1000],
                    ['name' => 'VIP', 'price' => 300000, 'quota' => 200],
                    ['name' => 'VVIP', 'price' => 500000, 'quota' => 50],
                ],
            ],
            [
                'event_slug' => 'festival-kuliner-internasional',
                'types' => [
                    ['name' => 'Terusan', 'price' => 100000, 'quota' => 2000],
                    ['name' => 'Meja Khusus', 'price' => 250000, 'quota' => 500],
                ],
            ],
        ];

        foreach ($ticketConfigs as $config) {
            $event = Event::where('slug', $config['event_slug'])->first();
            if ($event) {
                foreach ($config['types'] as $type) {
                    TicketType::firstOrCreate(
                        ['event_id' => $event->id, 'name' => $type['name']],
                        array_merge(['event_id' => $event->id], $type)
                    );
                }
            }
        }
    }
}
