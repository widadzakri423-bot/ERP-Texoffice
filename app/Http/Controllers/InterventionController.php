<?php

namespace App\Http\Controllers;

use App\Models\Intervention;
use App\Models\Machine;
use Illuminate\Http\Request;

class InterventionController extends Controller
{
    public function index()
    {
        $interventions = Intervention::with('machine')->latest()->get();
        return view('interventions.index', compact('interventions'));
    }

    public function create()
    {
        $machines = Machine::all();
        return view('interventions.create', compact('machines'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'date_intervention' => 'required|date',
            'description' => 'required|string',
            'cout' => 'nullable|numeric',
            'type' => 'required|in:preventive,corrective,revision',
            'technicien' => 'nullable|string',
            'pieces_remplacees' => 'nullable|string',
        ]);

        Intervention::create($data);

        // Mettre la machine en maintenance si corrective
        if ($data['type'] === 'corrective') {
            Machine::find($data['machine_id'])->update(['etat' => 'en_maintenance']);
        }

        return redirect()->route('interventions.index')->with('success', 'Intervention enregistrée.');
    }

    public function show(Intervention $intervention)
    {
        return view('interventions.show', compact('intervention'));
    }

    public function edit(Intervention $intervention)
    {
        $machines = Machine::all();
        return view('interventions.edit', compact('intervention', 'machines'));
    }

    public function update(Request $request, Intervention $intervention)
    {
        $data = $request->validate([
            'machine_id' => 'required|exists:machines,id',
            'date_intervention' => 'required|date',
            'description' => 'required|string',
            'cout' => 'nullable|numeric',
            'type' => 'required|in:preventive,corrective,revision',
            'technicien' => 'nullable|string',
            'pieces_remplacees' => 'nullable|string',
        ]);

        $intervention->update($data);
        return redirect()->route('interventions.index')->with('success', 'Intervention modifiée.');
    }

    public function destroy(Intervention $intervention)
    {
        $intervention->delete();
        return redirect()->route('interventions.index')->with('success', 'Intervention supprimée.');
    }
}