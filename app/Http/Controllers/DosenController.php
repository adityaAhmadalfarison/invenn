<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDosenRequest;
use App\Http\Requests\UpdateDosenRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DosenController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(User::class, 'user');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roleId = 4; // Role ID for Dosen
        $users = User::role('dosen')->whereNotIn('id', [auth()->id()])->get(); // Menggunakan whereNotIn()
        $roles = Role::withCount('users')->get();
    
        return view('dosens.index', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDosenRequest $request)
    {
        $validated = $request->validated();
        $role = Role::findById(4); // Role ID for Dosen

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        $user->assignRole($role);

        return to_route('dosens.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, Dosen $dosen)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$dosen->name,
            // Add other fields to validate
        ]);

        // Update the dosen
        $dosen->update($validatedData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Dosen updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route('dosens.index')->with('success', 'Data berhasil dihapus!');
    }

    public function show($id)
{
    $dosen = User::findOrFail($id); // Adjust this based on your model and database structure
    return response()->json(['data' => $dosen]);
}
}
