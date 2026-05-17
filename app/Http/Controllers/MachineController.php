<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    public function index()
    {
        return view('machines.index', ['machines' => Machine::all()]);
    }

    public function create()
    {
        return view('machines.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'reference' => 'required|string|unique:machines',
            'designation' => 'required|string',
            'marque' => 'nullable|string',
            'modele' => 'nullable|string',
            'etat' => 'nullable|in:disponible,en_maintenance,hors_service,occupe',
            'date_acquisition' => 'nullable|date',
            'cout_heure' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        Machine::create($data);
        return redirect()->route('machines.index')->with('success', 'Machine créée.');
    }

    public function show(Machine $machine)
    {
        return view('machines.show', compact('machine'));
    }

    public function edit(Machine $machine)
    {
        return view('machines.edit', compact('machine'));
    }

    public function update(Request $request, Machine $machine)
    {
        $data = $request->validate([
            'reference' => 'sometimes|required|string|unique:machines,reference,' . $machine->id,
            'designation' => 'sometimes|required|string',
            'marque' => 'nullable|string',
            'modele' => 'nullable|string',
            'etat' => 'nullable|in:disponible,en_maintenance,hors_service,occupe',
            'date_acquisition' => 'nullable|date',
            'cout_heure' => 'nullable|numeric',
            'notes' => 'nullable|string',
        ]);

        $machine->update($data);
        return redirect()->route('machines.index')->with('success', 'Machine modifiée.');
    }

    public function destroy(Machine $machine)
    {
        $machine->delete();
        return redirect()->route('machines.index')->with('success', 'Machine supprimée.');
    }
}