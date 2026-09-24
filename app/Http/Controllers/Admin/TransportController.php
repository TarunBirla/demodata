<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Route;

class TransportController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;

        $vehicles = Vehicle::where('school_id', $schoolId)->latest()->get();
        $routes = Route::with('vehicle')->where('school_id', $schoolId)->latest()->get();

        return view('admin.transport.index', compact('vehicles', 'routes'));
    }

    public function storeVehicle(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $validated = $request->validate([
            'registration_number' => 'required|string|max:100',
            'vehicle_type' => 'required|string|max:100',
            'capacity' => 'required|integer|min:1',
            'driver_name' => 'nullable|string|max:255',
            'driver_phone' => 'nullable|string|max:50',
        ]);

        Vehicle::create(array_merge($validated, [
            'school_id' => $schoolId,
            'status' => 'active',
        ]));

        return back()->with('success', 'Vehicle registered successfully!');
    }

    public function storeRoute(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $validated = $request->validate([
            'route_name' => 'required|string|max:255',
            'vehicle_id' => 'nullable|exists:vehicles,id',
            'fee' => 'required|numeric|min:0',
            'stops' => 'nullable|string',
        ]);

        Route::create(array_merge($validated, [
            'school_id' => $schoolId,
        ]));

        return back()->with('success', 'Transport route created successfully!');
    }
}
