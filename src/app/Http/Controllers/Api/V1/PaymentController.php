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
        ]);

        $booking = Booking::findOrFail($validated['booking_id']);

        $this->authorize('view', $booking);

        $payment = Payment::create([
            'booking_id' => $booking->id,
            'payment_method' => $validated['payment_method'],
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

        $payment->update([
            'status' => 'success',
            'paid_at' => now(),
        ]);

        $payment->booking->update(['status' => 'paid']);

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
