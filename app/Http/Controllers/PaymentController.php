<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Get all payments
    public function getAllPayments()
    {
        $payments = Payment::all();
        $paymentscount = $payments->count();

        // If perams count=true then return only count of payments
        if (request()->count) {
            return response()->json([
                'message' => 'Payments count retrieved successfully',
                'count' => $paymentscount
            ]);
        }

        return response()->json([
            'message' => 'Payments retrieved successfully',
            'count' => $paymentscount,
            'payments' => $payments
        ]);
    }

    // Get payment by id
    public function getPaymentById($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Payment retrieved successfully',
            'payment' => $payment
        ]);
    }

    // Create payment
    public function createPayment(Request $request)
    {
        $payment = Payment::create($request->all());

        return response()->json([
            'message' => 'Payment created successfully',
            'payment' => $payment
        ]);
    }

    // Update payment by id
    public function updatePayment(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        $payment->update($request->all());

        return response()->json([
            'message' => 'Payment updated successfully',
            'payment' => $payment
        ]);
    }

    // Delete payment by id
    public function deletePayment($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'message' => 'Payment not found'
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'message' => 'Payment deleted successfully'
        ]);
    }
}
