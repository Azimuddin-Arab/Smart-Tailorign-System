<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    // List all customers
    public function index()
    {
        try {
            $customers = Customer::all();
            return response()->json($customers, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error fetching customers',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Store a new customer
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'full_name' => 'required|string|max:100',
                'phone' => 'required|string|max:20',
                'email' => 'nullable|email|max:100',
                'address' => 'nullable|string',
            ]);

            $customer = Customer::create($validated);

            return response()->json([
                'message' => 'Customer created successfully',
                'data' => $customer
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Server error. Please try again later.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Show a customer with relations
    public function show($id)
    {
        $customer = Customer::with('orders', 'measurements')->find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer, 200);
    }

    // Edit a customer
   public function edit(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json([
            'data'    => $customer
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        
        $validated = $request->validate([
            'full_name' => 'required | string|max:255',
            'phone' => 'required |string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string|max:250'
        ]);

        $customer->update($validated);

        return response()->json([
            'message' => 'Customer Updated successfully',
            'data' => $customer
        ], 200);
    }


    // Delete a customer
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (!$customer) return response()->json(['message' => 'Customer not found'], 404);

        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully'], 200);
    }
}
