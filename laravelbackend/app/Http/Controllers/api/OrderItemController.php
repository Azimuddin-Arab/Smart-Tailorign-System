<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    public function index()
    {
        return response()->json(OrderItem::with('order')->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
            'item_name' => 'required|string|max:100',
            'fabric_type' => 'nullable|string|max:100',
            'quantity' => 'required|integer|min:1',
            'price' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $item = OrderItem::create($validated);
        return response()->json(['message' => 'Order item created successfully', 'data' => $item], 201);
    }

    public function show($id)
    {
        $item = OrderItem::with('order')->find($id);
        if (!$item) return response()->json(['message' => 'Order item not found'], 404);
        return response()->json($item);
    }

    public function update(Request $request, $id)
    {
        $item = OrderItem::find($id);
        if (!$item) return response()->json(['message' => 'Order item not found'], 404);

        $item->update($request->all());
        return response()->json(['message' => 'Order item updated successfully', 'data' => $item]);
    }

    public function destroy($id)
    {
        $item = OrderItem::find($id);
        if (!$item) return response()->json(['message' => 'Order item not found'], 404);

        $item->delete();
        return response()->json(['message' => 'Order item deleted successfully']);
    }
}
