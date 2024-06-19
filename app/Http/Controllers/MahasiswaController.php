<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMahasiswaRequest;
use App\Http\Requests\UpdateMahasiswaRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;

class MahasiswaController extends Controller
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
        $users = User::role('mahasiswa')->whereNotIn('id', [auth()->id()])->get(); // Menggunakan whereNotIn()
        $roles = Role::withCount('users')->get();
    
        return view('mahasiswas.index', compact('users', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMahasiswaRequest $request)
    {
        $validated = $request->validated();
        $role = Role::findById(3); // Role ID for Dosen

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);
        $user->assignRole($role);

        return to_route('mahasiswas.index')->with('success', 'Data berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        // Validate the request
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$mahasiswa->name,
            // Add other fields to validate
        ]);

        // Update the dosen
        $mahasiswa->update($validatedData);

        // Redirect back with success message
        return redirect()->back()->with('success', 'Dosen updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return to_route('mahasiswas.index')->with('success', 'Data berhasil dihapus!');
    }

    public function show($id)
{
    $mahasiswa = User::findOrFail($id); // Adjust this based on your model and database structure
    return response()->json(['data' => $mahasiswa]);
}
}
