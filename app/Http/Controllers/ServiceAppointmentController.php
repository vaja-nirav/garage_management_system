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
}
