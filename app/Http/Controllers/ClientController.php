<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $this->authorize('clients.view');
        return view('clients.index');
    }

    public function create()
    {
        $this->authorize('clients.create');
        return view('clients.create');
    }

    public function store(Request $request)
    {
        $this->authorize('clients.create');

        $validated = $request->validate([
            'document_type' => 'required|in:CC,CE,TI,PP',
            'document_number' => 'required|string|max:20|unique:clients,document_number',
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'second_last_name' => 'nullable|string|max:100',
            'birth_date' => 'required|date|before:-18 years',
            'birth_place' => 'nullable|string|max:100',
            'gender' => 'required|in:M,F,Otro,Prefiero no decir',
            'marital_status' => 'required|in:soltero,casado,union_libre,divorciado,viudo',
            'education_level' => 'required|in:primaria,secundaria,tecnico,tecnologo,profesional,posgrado',
            'dependents_count' => 'required|integer|min:0',
        ]);

        $validated['full_name'] = trim(implode(' ', array_filter([
            $validated['first_name'],
            $validated['middle_name'] ?? null,
            $validated['last_name'],
            $validated['second_last_name'] ?? null
        ])));

        $client = Client::create($validated);

        return redirect()->route('clients.show', $client)
            ->with('success', 'Cliente registrado exitosamente');
    }

    public function show(Client $client)
    {
        $this->authorize('clients.view');
        $client->load(['contacts', 'currentEmployment', 'latestFinancial', 'references', 'documents', 'latestMidatacredito']);
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        $this->authorize('clients.edit');
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $this->authorize('clients.edit');

        $validated = $request->validate([
            'document_type' => 'required|in:CC,CE,TI,PP',
            'document_number' => 'required|string|max:20|unique:clients,document_number,' . $client->id,
            'first_name' => 'required|string|max:100',
            'middle_name' => 'nullable|string|max:100',
            'last_name' => 'required|string|max:100',
            'second_last_name' => 'nullable|string|max:100',
            'birth_date' => 'required|date|before:-18 years',
            'birth_place' => 'nullable|string|max:100',
            'gender' => 'required|in:M,F,Otro,Prefiero no decir',
            'marital_status' => 'required|in:soltero,casado,union_libre,divorciado,viudo',
            'education_level' => 'required|in:primaria,secundaria,tecnico,tecnologo,profesional,posgrado',
            'dependents_count' => 'required|integer|min:0',
        ]);

        $validated['full_name'] = trim(implode(' ', array_filter([
            $validated['first_name'],
            $validated['middle_name'] ?? null,
            $validated['last_name'],
            $validated['second_last_name'] ?? null
        ])));

        $client->update($validated);

        return redirect()->route('clients.show', $client)
            ->with('success', 'Cliente actualizado exitosamente');
    }

    public function destroy(Client $client)
    {
        $this->authorize('clients.delete');
        $client->delete();

        return redirect()->route('clients.index')
            ->with('success', 'Cliente eliminado exitosamente');
    }
}
