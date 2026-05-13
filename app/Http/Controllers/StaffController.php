<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Garage;
use Illuminate\Http\Request;
use App\Http\Requests\StoreStaffRequest;
use App\Http\Requests\UpdateStaffRequest;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('garage')->paginate(10);
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $garages = Garage::all();
        return view('staff.create', compact('garages'));
    }

    public function store(StoreStaffRequest $request)
    {
        Staff::create($request->validated());
        return redirect()->route('staff.index')->with('success', 'Staff created.');
    }

    public function show(Staff $staff)
    {
        return view('staff.show', compact('staff'));
    }

    public function edit(Staff $staff)
    {
        $garages = Garage::all();
        return view('staff.edit', compact('staff', 'garages'));
    }

    public function update(UpdateStaffRequest $request, Staff $staff)
    {
        $staff->update($request->validated());
        return redirect()->route('staff.index')->with('success', 'Staff updated.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff deleted.');
    }
}
