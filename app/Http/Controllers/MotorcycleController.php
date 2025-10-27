<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MotorcycleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('motorcycles.view');

        $motorcycles = DB::table('motorcycles')
            ->leftJoin('users', 'motorcycles.current_owner_id', '=', 'users.id')
            ->select('motorcycles.*', 'users.name as owner_name')
            ->whereNull('motorcycles.deleted_at')
            ->orderBy('motorcycles.created_at', 'desc')
            ->paginate(15);

        return view('motorcycles.index', compact('motorcycles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('motorcycles.create');

        $users = \App\Models\User::where('is_active', true)->get();
        return view('motorcycles.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('motorcycles.create');

        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'displacement' => 'required|string|max:50',
            'plate' => 'required|string|max:20|unique:motorcycles,plate',
            'motor_number' => 'required|string|max:100|unique:motorcycles,motor_number',
            'chassis_number' => 'required|string|max:100|unique:motorcycles,chassis_number',
            'color' => 'nullable|string|max:50',
            'status' => 'required|in:active,in_maintenance,damaged,sold,inactive',
            'current_owner_id' => 'nullable|exists:users,id',
            'purchase_price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        DB::table('motorcycles')->insert([
            'brand' => $validated['brand'],
            'model' => $validated['model'],
            'year' => $validated['year'],
            'displacement' => $validated['displacement'],
            'plate' => strtoupper($validated['plate']),
            'motor_number' => strtoupper($validated['motor_number']),
            'chassis_number' => strtoupper($validated['chassis_number']),
            'color' => $validated['color'],
            'status' => $validated['status'],
            'current_owner_id' => $validated['current_owner_id'],
            'purchase_price' => $validated['purchase_price'],
            'purchase_date' => $validated['purchase_date'],
            'notes' => $validated['notes'],
            'created_by' => auth()->id(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('motorcycles.index')
            ->with('success', 'Motocicleta registrada exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $this->authorize('motorcycles.view');

        $motorcycle = DB::table('motorcycles')
            ->leftJoin('users as owner', 'motorcycles.current_owner_id', '=', 'owner.id')
            ->leftJoin('users as creator', 'motorcycles.created_by', '=', 'creator.id')
            ->select(
                'motorcycles.*',
                'owner.name as owner_name',
                'owner.email as owner_email',
                'owner.phone as owner_phone',
                'creator.name as created_by_name'
            )
            ->where('motorcycles.id', $id)
            ->whereNull('motorcycles.deleted_at')
            ->first();

        if (!$motorcycle) {
            return redirect()->route('motorcycles.index')
                ->with('error', 'Motocicleta no encontrada');
        }

        // Get maintenance records
        $maintenances = DB::table('motorcycle_maintenances')
            ->where('motorcycle_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('scheduled_date', 'desc')
            ->limit(5)
            ->get();

        // Get incidents
        $incidents = DB::table('motorcycle_incidents')
            ->where('motorcycle_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('incident_date', 'desc')
            ->limit(5)
            ->get();

        // Get documents
        $documents = DB::table('motorcycle_documents')
            ->where('motorcycle_id', $id)
            ->whereNull('deleted_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('motorcycles.show', compact('motorcycle', 'maintenances', 'incidents', 'documents'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $this->authorize('motorcycles.edit');

        $motorcycle = DB::table('motorcycles')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$motorcycle) {
            return redirect()->route('motorcycles.index')
                ->with('error', 'Motocicleta no encontrada');
        }

        $users = \App\Models\User::where('is_active', true)->get();

        return view('motorcycles.edit', compact('motorcycle', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->authorize('motorcycles.edit');

        $motorcycle = DB::table('motorcycles')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$motorcycle) {
            return redirect()->route('motorcycles.index')
                ->with('error', 'Motocicleta no encontrada');
        }

        $validated = $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'year' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'displacement' => 'required|string|max:50',
            'plate' => 'required|string|max:20|unique:motorcycles,plate,' . $id,
            'motor_number' => 'required|string|max:100|unique:motorcycles,motor_number,' . $id,
            'chassis_number' => 'required|string|max:100|unique:motorcycles,chassis_number,' . $id,
            'color' => 'nullable|string|max:50',
            'status' => 'required|in:active,in_maintenance,damaged,sold,inactive',
            'current_owner_id' => 'nullable|exists:users,id',
            'purchase_price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ]);

        DB::table('motorcycles')
            ->where('id', $id)
            ->update([
                'brand' => $validated['brand'],
                'model' => $validated['model'],
                'year' => $validated['year'],
                'displacement' => $validated['displacement'],
                'plate' => strtoupper($validated['plate']),
                'motor_number' => strtoupper($validated['motor_number']),
                'chassis_number' => strtoupper($validated['chassis_number']),
                'color' => $validated['color'],
                'status' => $validated['status'],
                'current_owner_id' => $validated['current_owner_id'],
                'purchase_price' => $validated['purchase_price'],
                'purchase_date' => $validated['purchase_date'],
                'notes' => $validated['notes'],
                'updated_by' => auth()->id(),
                'updated_at' => now(),
            ]);

        return redirect()->route('motorcycles.index')
            ->with('success', 'Motocicleta actualizada exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorize('motorcycles.delete');

        $motorcycle = DB::table('motorcycles')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();

        if (!$motorcycle) {
            return redirect()->route('motorcycles.index')
                ->with('error', 'Motocicleta no encontrada');
        }

        DB::table('motorcycles')
            ->where('id', $id)
            ->update(['deleted_at' => now()]);

        return redirect()->route('motorcycles.index')
            ->with('success', 'Motocicleta eliminada exitosamente');
    }
}
