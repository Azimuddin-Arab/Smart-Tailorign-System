<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display all orders with related customer and items.
     */
    public function index()
    {
        $orders = Order::with(['customer', 'items'])->latest()->get();
        return response()->json($orders);
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'   => 'required|exists:customers,id',
            'order_date'    => 'required|date',
            'due_date'      => 'nullable|date|after_or_equal:order_date',
            'status'        => 'required|string|max:50',
            'total_price'   => 'required|numeric|min:0',
            'advance_paid'  => 'nullable|numeric|min:0',
            'notes'         => 'nullable|string|max:500',
        ]);

        $order = Order::create($validated);

        return response()->json([
            'message' => 'Order created successfully.',
            'data'    => $order->load(['customer', 'items'])
        ], 201);
    }

    /**
     * Display a single order.
     */
    public function show($id)
    {
        $order = Order::with(['customer', 'items'])->find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        return response()->json($order);
    }

    /**
     * Update an existing order.
     */
    public function update(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $validated = $request->validate([
            'customer_id'   => 'sometimes|exists:customers,id',
            'order_date'    => 'sometimes|date',
            'due_date'      => 'nullable|date|after_or_equal:order_date',
            'status'        => 'sometimes|string|max:50',
            'total_price'   => 'sometimes|numeric|min:0',
            'advance_paid'  => 'nullable|numeric|min:0',
            'notes'         => 'nullable|string|max:500',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Order updated successfully.',
            'data'    => $order->load(['customer', 'items'])
        ]);
    }

    /**
     * Delete an order.
     */
    public function destroy($id)
    {
        $order = Order::find($id);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully.']);
    }
}
