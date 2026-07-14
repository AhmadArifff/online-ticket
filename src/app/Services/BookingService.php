<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookingService
{
    public function createBooking(array $items, $userId)
    {
        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $bookingCode = 'TB-' . date('Ymd') . '-' . Str::random(4);
            $reservedUntil = now()->addMinutes(10);

            $booking = Booking::create([
                'user_id' => $userId,
                'booking_code' => $bookingCode,
                'total_amount' => 0,
                'status' => 'reserved',
                'reserved_until' => $reservedUntil,
            ]);

            foreach ($items as $item) {
                $ticketType = \App\Models\TicketType::where('id', $item['ticket_type_id'])
                    ->lockForUpdate()
                    ->firstOrFail();

                if (($ticketType->quota - $ticketType->sold) < $item['quantity']) {
                    throw new \Exception('Insufficient ticket quota for ' . $ticketType->name);
                }

                $subtotal = $ticketType->price * $item['quantity'];
                $totalAmount += $subtotal;

                $bookingDetail = BookingDetail::create([
                    'booking_id' => $booking->id,
                    'ticket_type_id' => $ticketType->id,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ]);

                for ($i = 0; $i < $item['quantity']; $i++) {
                    Ticket::create([
                        'booking_detail_id' => $bookingDetail->id,
                        'ticket_code' => 'TK-' . $booking->id . '-' . Str::random(6),
                        'qr_code' => null,
                    ]);
                }

                $ticketType->increment('sold', $item['quantity']);
            }

            $booking->update(['total_amount' => $totalAmount]);

            DB::commit();

            return $booking->load(['bookingDetails', 'tickets']);

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function cancelBooking(Booking $booking)
    {
        if (!in_array($booking->status, ['pending', 'paid'])) {
            throw new \Exception('Cannot cancel this booking');
        }

        DB::beginTransaction();

        try {
            $booking->update(['status' => 'cancelled']);

            foreach ($booking->bookingDetails as $detail) {
                $detail->ticketType->decrement('sold', $detail->quantity);
            }

            DB::commit();

            return $booking;

        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function expireBooking(Booking $booking)
    {
        if ($booking->status !== 'reserved' || $booking->reserved_until === null || $booking->reserved_until->isFuture()) {
            throw new \Exception('Booking is not eligible for expiration');
        }

        DB::beginTransaction();

        try {
            $booking->update(['status' => 'expired']);

            foreach ($booking->bookingDetails as $detail) {
                $detail->ticketType->decrement('sold', $detail->quantity);
            }

            DB::commit();

            return $booking;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function useTicket(Ticket $ticket)
    {
        if ($ticket->is_used) {
            throw new \Exception('Ticket already used');
        }

        $ticket->update([
            'is_used' => true,
            'used_at' => now(),
        ]);

        return $ticket;
    }
}
