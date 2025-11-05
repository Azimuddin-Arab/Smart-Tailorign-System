<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        return response()->json(Payment::with('order')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'payment_date' => 'nullable|date',
            'amount' => 'required|numeric',
            'method' => 'nullable|string|max:50',
            'remarks' => 'nullable|string',
        ]);

        $payment = Payment::create($validated);
        return response()->json(['message' => 'Payment recorded successfully', 'data' => $payment], 201);
    }

    public function show($id)
    {
        $payment = Payment::with('order')->find($id);
        if (!$payment) return response()->json(['message' => 'Payment not found'], 404);
        return response()->json($payment);
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);
        if (!$payment) return response()->json(['message' => 'Payment not found'], 404);

        $payment->update($request->all());
        return response()->json(['message' => 'Payment updated successfully', 'data' => $payment]);
    }

    public function destroy($id)
    {
        $payment = Payment::find($id);
        if (!$payment) return response()->json(['message' => 'Payment not found'], 404);

        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully']);
    }
}
