<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Payment;
use App\Models\Ticket;
use App\Models\TicketType;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BookingSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role', 'customer')->get();
        if ($customers->isEmpty()) {
            return;
        }

        $ticketTypes = TicketType::take(6)->get();
        if ($ticketTypes->isEmpty()) {
            return;
        }

        $seedBookings = [
            [
                'booking_code' => 'BOOK-2026-001',
                'user_id' => $customers->random()->id,
                'status' => 'paid',
                'reserved_until' => null,
                'payment_method' => 'credit_card',
                'payment_status' => 'completed',
                'items' => [
                    ['ticket_type_id' => $ticketTypes[0]->id, 'quantity' => 2],
                    ['ticket_type_id' => $ticketTypes[1]->id, 'quantity' => 1],
                ],
            ],
            [
                'booking_code' => 'BOOK-2026-002',
                'user_id' => $customers->random()->id,
                'status' => 'pending',
                'reserved_until' => null,
                'payment_method' => 'bank_transfer',
                'payment_status' => 'pending',
                'items' => [
                    ['ticket_type_id' => $ticketTypes[2]->id, 'quantity' => 1],
                ],
            ],
            [
                'booking_code' => 'BOOK-2026-003',
                'user_id' => $customers->random()->id,
                'status' => 'reserved',
                'reserved_until' => Carbon::now()->addMinutes(30),
                'payment_method' => 'e-wallet',
                'payment_status' => 'pending',
                'items' => [
                    ['ticket_type_id' => $ticketTypes[3]->id, 'quantity' => 3],
                ],
            ],
            [
                'booking_code' => 'BOOK-2026-004',
                'user_id' => $customers->random()->id,
                'status' => 'cancelled',
                'reserved_until' => null,
                'payment_method' => 'credit_card',
                'payment_status' => 'failed',
                'items' => [
                    ['ticket_type_id' => $ticketTypes[4]->id, 'quantity' => 1],
                ],
            ],
            [
                'booking_code' => 'BOOK-2026-005',
                'user_id' => $customers->random()->id,
                'status' => 'paid',
                'reserved_until' => null,
                'payment_method' => 'bank_transfer',
                'payment_status' => 'completed',
                'items' => [
                    ['ticket_type_id' => $ticketTypes[5]->id, 'quantity' => 2],
                ],
            ],
        ];

        foreach ($seedBookings as $seed) {
            $booking = Booking::firstOrCreate(
                ['booking_code' => $seed['booking_code']],
                [
                    'user_id' => $seed['user_id'],
                    'total_amount' => 0,
                    'status' => $seed['status'],
                    'reserved_until' => $seed['reserved_until'],
                ]
            );

            $totalAmount = 0;

            foreach ($seed['items'] as $item) {
                $ticketType = TicketType::find($item['ticket_type_id']);
                if (! $ticketType) {
                    continue;
                }

                $subtotal = $ticketType->price * $item['quantity'];

                $detail = BookingDetail::firstOrCreate(
                    [
                        'booking_id' => $booking->id,
                        'ticket_type_id' => $ticketType->id,
                    ],
                    [
                        'quantity' => $item['quantity'],
                        'subtotal' => $subtotal,
                    ]
                );

                if ($detail->wasRecentlyCreated) {
                    $ticketType->increment('sold', $item['quantity']);
                }

                $totalAmount += $detail->subtotal;

                // Create one ticket record per quantity.
                for ($i = 0; $i < $item['quantity']; $i++) {
                    $code = 'TCK-' . Str::upper(Str::random(8));
                    Ticket::firstOrCreate(
                        ['ticket_code' => $code],
                        [
                            'booking_detail_id' => $detail->id,
                            'qr_code' => 'QR-' . Str::upper(Str::random(10)),
                            'is_used' => false,
                        ]
                    );
                }
            }

            if ($booking->total_amount !== $totalAmount) {
                $booking->update(['total_amount' => $totalAmount]);
            }

            if ($seed['status'] === 'paid' || $seed['payment_status'] === 'pending' || $seed['payment_status'] === 'failed') {
                Payment::firstOrCreate(
                    [
                        'booking_id' => $booking->id,
                        'payment_method' => $seed['payment_method'],
                        'status' => $seed['payment_status'],
                    ],
                    [
                        'amount' => $totalAmount,
                        'paid_at' => $seed['payment_status'] === 'completed' ? Carbon::now() : null,
                    ]
                );
            }
        }
    }
}
