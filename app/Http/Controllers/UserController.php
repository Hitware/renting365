<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('users.view');

        $users = User::with(['roles', 'profile'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('users.create');

        $roles = \App\Models\Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('users.create');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'boolean',
            // Profile fields
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'document_type' => 'required|in:CC,CE,TI,PP',
            'document_number' => 'required|string|max:20|unique:user_profiles',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => \Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'is_active' => $request->has('is_active'),
            'email_verified_at' => now(),
        ]);

        // Create profile
        $user->profile()->create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'document_type' => $validated['document_type'],
            'document_number' => $validated['document_number'],
        ]);

        // Assign role
        $user->assignRole(\App\Models\Role::find($validated['role_id']));

        return redirect()->route('users.index')
            ->with('success', 'Usuario creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('users.edit');

        $user->load(['profile', 'roles']);
        $roles = \App\Models\Role::all();

        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $this->authorize('users.edit');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'is_active' => 'boolean',
            // Profile fields
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'document_type' => 'required|in:CC,CE,TI,PP',
            'document_number' => 'required|string|max:20|unique:user_profiles,document_number,' . ($user->profile->id ?? 'NULL'),
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'is_active' => $request->has('is_active'),
        ]);

        if (!empty($validated['password'])) {
            $user->update(['password' => \Hash::make($validated['password'])]);
        }

        // Update or create profile
        $user->profile()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'document_type' => $validated['document_type'],
                'document_number' => $validated['document_number'],
            ]
        );

        // Update role
        $user->roles()->sync([$validated['role_id']]);

        return redirect()->route('users.index')
            ->with('success', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('users.delete');

        // Don't allow deleting yourself
        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')
                ->with('error', 'No puedes eliminar tu propia cuenta');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Usuario eliminado exitosamente');
    }
}
