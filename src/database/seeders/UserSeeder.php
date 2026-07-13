<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'admin@ticketing.com'],
            [
                'name' => 'Admin',
                'email' => 'admin@ticketing.com',
                'password' => bcrypt('password'),
                'phone' => '081234567890',
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Customer users
        $customers = [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '081234567891'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '081234567892'],
            ['name' => 'Bob Wilson', 'email' => 'bob@example.com', 'phone' => '081234567893'],
        ];

        foreach ($customers as $customer) {
            User::firstOrCreate(
                ['email' => $customer['email']],
                array_merge($customer, [
                    'password' => bcrypt('password'),
                    'role' => 'customer',
                    'email_verified_at' => now(),
                ])
            );
        }
    }
}
