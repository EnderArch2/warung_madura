<?php

namespace App\Http\Controllers;
use App\Models\Distributor;
use Illuminate\Http\Request;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('distributors.index', [
            'title' => 'Distributors',
            'data' => Distributor::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('distributors.create', [
            'title' => 'Distributors'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:50',
        ]);

        // create record
        Distributor::create($validated);

        // redirect back to list with success message
        return redirect()->route('distributors.index')
                         ->with('success', 'Distributor added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // not needed at the moment
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $distributor = Distributor::findOrFail($id);
        return view('distributors.edit', [
            'title' => 'Distributors',
            'distributor' => $distributor
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $distributor = Distributor::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone_number' => 'required|string|max:50',
        ]);

        $distributor->update($validated);

        return redirect()->route('distributors.index')
                         ->with('success', 'Distributor updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $distributor = Distributor::findOrFail($id);
        $distributor->delete();

        return redirect()->route('distributors.index')
                         ->with('success', 'Distributor deleted successfully.');
    }
}
