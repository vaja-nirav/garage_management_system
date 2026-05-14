<?php

namespace App\Http\Controllers;

use App\Models\ServiceAppointment;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Garage;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAppointmentRequest;

class ServiceAppointmentController extends Controller
{
    public function index()
    {
        $appointments = ServiceAppointment::with(['customer', 'vehicle', 'garage'])->paginate(10);
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $garages = Garage::all();
        return view('appointments.create', compact('customers', 'vehicles', 'garages'));
    }

    public function store(StoreAppointmentRequest $request)
    {
        ServiceAppointment::create($request->validated());

        return redirect()->route('appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    public function show(ServiceAppointment $appointment)
    {
        $appointment->load(['customer', 'vehicle', 'garage']);
        return view('appointments.show', compact('appointment'));
    }

    public function edit(ServiceAppointment $appointment)
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $garages = Garage::all();
        return view('appointments.edit', compact('appointment', 'customers', 'vehicles', 'garages'));
    }

    public function update(Request $request, ServiceAppointment $appointment)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'garage_id' => 'required|exists:garages,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'status' => 'required|string',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(ServiceAppointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }
}
