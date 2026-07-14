<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function process(): JsonResponse
    {
        $validated = request()->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|in:transfer,card,ewallet',
            'transaction_id' => 'required|string|unique:payments,transaction_id',
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        $this->authorize('view', $booking);

        if (!in_array($booking->status, ['pending', 'reserved'])) {
            return response()->json([
                'success' => false,
                'message' => 'Booking cannot be paid in its current status',
            ], 422);
        }

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'payment_method' => $validated['payment_method'],
            'transaction_id' => $validated['transaction_id'],
            'amount' => $booking->total_amount,
            'status' => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment initiated',
            'data' => $payment,
        ]);
    }

    public function verify(Payment $payment): JsonResponse
    {
        if ($payment->status === 'success') {
            return response()->json([
                'success' => false,
                'message' => 'Payment already verified',
            ], 422);
        }

        if ($payment->booking->status === 'expired') {
            return response()->json([
                'success' => false,
                'message' => 'Cannot verify payment for expired booking',
            ], 422);
        }

        $payment->update([
            'status' => 'success',
            'paid_at' => now(),
        ]);

        $payment->booking->update([
            'status' => 'paid',
            'reserved_until' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Payment verified successfully',
            'data' => $payment,
        ]);
    }

    public function show(Payment $payment): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }
}
