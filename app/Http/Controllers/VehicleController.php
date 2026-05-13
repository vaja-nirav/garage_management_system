<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Garage;
use App\Models\Customer;
use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::with(['garage', 'customer'])->paginate(10);
        return view('vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $garages = Garage::all();
        $customers = Customer::all();
        return view('vehicles.create', compact('garages', 'customers'));
    }

    public function store(StoreVehicleRequest $request)
    {
        Vehicle::create($request->validated());
        return redirect()->route('vehicles.index')->with('success', 'Vehicle created.');
    }

    public function show(Vehicle $vehicle)
    {
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        $garages = Garage::all();
        $customers = Customer::all();
        return view('vehicles.edit', compact('vehicle', 'garages', 'customers'));
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());
        return redirect()->route('vehicles.index')->with('success', 'Vehicle updated.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('success', 'Vehicle deleted.');
    }
}
