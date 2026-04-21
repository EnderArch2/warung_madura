<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;

class CourierController extends Controller
{
    /**
     * Display a listing of courier users.
     */
    public function index()
    {
        return view('couriers.index', [
            'title' => 'Couriers',
            'data' => User::where('role', 'courier')->get()
        ]);
    }

    /**
     * Show the form for creating a new courier.
     */
    public function create()
    {
        return view('couriers.create', [
            'title' => 'Couriers'
        ]);
    }

    /**
     * Store a newly created courier in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        // Add courier role
        $validated['role'] = 'courier';
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('couriers.index')
                         ->with('success', 'Courier added successfully.');
    }

    /**
     * Show the form for editing a courier.
     */
    public function edit(string $id)
    {
        $courier = User::where('id', $id)->where('role', 'courier')->firstOrFail();
        return view('couriers.edit', [
            'title' => 'Couriers',
            'courier' => $courier
        ]);
    }

    /**
     * Update a courier in storage.
     */
    public function update(Request $request, string $id)
    {
        $courier = User::where('id', $id)->where('role', 'courier')->firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        $courier->update($validated);

        return redirect()->route('couriers.index')
                         ->with('success', 'Courier updated successfully.');
    }

    /**
     * Remove a courier from storage.
     */
    public function destroy(string $id)
    {
        $courier = User::where('id', $id)->where('role', 'courier')->firstOrFail();
        $courier->delete();

        return redirect()->route('couriers.index')
                         ->with('success', 'Courier deleted successfully.');
    }
}
