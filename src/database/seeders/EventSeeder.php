<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Event;
use App\Models\Category;
use App\Models\Venue;
use Carbon\Carbon;

class EventSeeder extends Seeder
{
    public function run(): void
    {
        $events = [
            [
                'category_id' => Category::where('slug', 'konser')->first()->id,
                'venue_id' => Venue::where('name', 'Jakarta Convention Center')->first()->id,
                'name' => 'Konser Musik Elektro 2026',
                'slug' => 'konser-musik-elektro-2026',
                'description' => 'Konser musik elektronik terbesar dengan artis internasional terkenal.',
                'banner_image' => 'https://via.placeholder.com/1200x400',
                'start_date' => Carbon::now()->addMonths(1)->setTime(18, 0),
                'end_date' => Carbon::now()->addMonths(1)->setTime(23, 0),
                'status' => 'published',
            ],
            [
                'category_id' => Category::where('slug', 'seminar')->first()->id,
                'venue_id' => Venue::where('name', 'Gran Melia Hotel')->first()->id,
                'name' => 'Seminar Digital Marketing',
                'slug' => 'seminar-digital-marketing',
                'description' => 'Seminar mendalam tentang strategi marketing digital terkini.',
                'banner_image' => 'https://via.placeholder.com/1200x400',
                'start_date' => Carbon::now()->addMonths(1)->addDays(5)->setTime(9, 0),
                'end_date' => Carbon::now()->addMonths(1)->addDays(5)->setTime(17, 0),
                'status' => 'published',
            ],
            [
                'category_id' => Category::where('slug', 'workshop')->first()->id,
                'venue_id' => Venue::where('name', 'Art Space Studio')->first()->id,
                'name' => 'Workshop Fotografi',
                'slug' => 'workshop-fotografi',
                'description' => 'Workshop praktis tentang teknik-teknik fotografi profesional.',
                'banner_image' => 'https://via.placeholder.com/1200x400',
                'start_date' => Carbon::now()->addMonths(1)->addDays(10)->setTime(10, 0),
                'end_date' => Carbon::now()->addMonths(1)->addDays(10)->setTime(16, 0),
                'status' => 'published',
            ],
            [
                'category_id' => Category::where('slug', 'olahraga')->first()->id,
                'venue_id' => Venue::where('name', 'Monas Bundaran')->first()->id,
                'name' => 'Pertandingan Basket Pro',
                'slug' => 'pertandingan-basket-pro',
                'description' => 'Pertandingan basket profesional antar tim terbaik.',
                'banner_image' => 'https://via.placeholder.com/1200x400',
                'start_date' => Carbon::now()->addMonths(1)->addDays(15)->setTime(19, 0),
                'end_date' => Carbon::now()->addMonths(1)->addDays(15)->setTime(22, 0),
                'status' => 'published',
            ],
            [
                'category_id' => Category::where('slug', 'festival')->first()->id,
                'venue_id' => Venue::where('name', 'Monas Bundaran')->first()->id,
                'name' => 'Festival Kuliner Internasional',
                'slug' => 'festival-kuliner-internasional',
                'description' => 'Festival kuliner dengan berbagai masakan dari seluruh dunia.',
                'banner_image' => 'https://via.placeholder.com/1200x400',
                'start_date' => Carbon::now()->addMonths(1)->addDays(20)->setTime(11, 0),
                'end_date' => Carbon::now()->addMonths(1)->addDays(20)->setTime(20, 0),
                'status' => 'published',
            ],
        ];

        foreach ($events as $event) {
            Event::firstOrCreate(['slug' => $event['slug']], $event);
        }
    }
}
