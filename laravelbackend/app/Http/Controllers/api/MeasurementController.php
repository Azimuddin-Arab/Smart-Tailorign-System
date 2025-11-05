<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Measurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    // List all measurements
    public function index()
    {
        return response()->json(Measurement::with('customer')->get(), 200);
    }

    // Add a new measurement
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'chest' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'hips' => 'nullable|numeric',
            'sleeve_length' => 'nullable|numeric',
            'shoulder' => 'nullable|numeric',
            'neck' => 'nullable|numeric',
            'inseam' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $measurement = Measurement::create($validated);

        return response()->json([
            'message' => 'Measurement added successfully',
            'data' => $measurement
        ], 201);
    }

    // Show a single measurement
    public function show($id)
    {
        $measurement = Measurement::with('customer')->find($id);

        if (!$measurement) {
            return response()->json(['message' => 'Measurement not found'], 404);
        }

        return response()->json($measurement, 200);
    }

    // Update a measurement
    public function update(Request $request, $id)
    {
        $measurement = Measurement::find($id);

        if (!$measurement) {
            return response()->json(['message' => 'Measurement not found'], 404);
        }

        // Validate input for update
        $validated = $request->validate([
            'customer_id' => 'sometimes|required|exists:customers,id',
            'chest' => 'nullable|numeric',
            'waist' => 'nullable|numeric',
            'hips' => 'nullable|numeric',
            'sleeve_length' => 'nullable|numeric',
            'shoulder' => 'nullable|numeric',
            'neck' => 'nullable|numeric',
            'inseam' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $measurement->update($validated);

        return response()->json([
            'message' => 'Measurement updated successfully',
            'data' => $measurement
        ], 200);
    }

    // Delete a measurement
    public function destroy($id)
    {
        $measurement = Measurement::find($id);

        if (!$measurement) {
            return response()->json(['message' => 'Measurement not found'], 404);
        }

        $measurement->delete();

        return response()->json(['message' => 'Measurement deleted successfully'], 200);
    }
}
