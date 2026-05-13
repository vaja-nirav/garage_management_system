<?php

namespace App\Http\Controllers;

use App\Models\ServiceJobCard;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Staff;   
use App\Models\Garage;
use App\Http\Requests\StoreJobCardRequest;

class ServiceJobCardController extends Controller
{
    public function index()
    {
        $jobCards = ServiceJobCard::with(['customer', 'vehicle', 'staff', 'garage'])->paginate(10);
        return view('job-cards.index', compact('jobCards'));
    }

    public function create()
    {
        $customers = Customer::all();
        $vehicles = Vehicle::all();
        $staff = Staff::all();
        $garages = Garage::all();
        return view('job-cards.create', compact('customers', 'vehicles', 'staff', 'garages'));
    }

    public function store(StoreJobCardRequest $request)
    {
        ServiceJobCard::create($request->validated());

        return redirect()->route('job-cards.index')->with('success', 'Job Card created successfully.');
    }
}
