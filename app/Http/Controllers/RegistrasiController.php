<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RegistrasiController extends Controller
{
    /**
     * Show the registration form.
     */
    public function showRegistrationForm()
    {
        $roles = Role::all();
        return view('auth.register', compact('roles'));
    }

    /**
     * Handle a registration request for the application.
     */
    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();
        $role = Role::findById($validated['role_id']);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);
        $user->assignRole($role);

        return to_route('login')->with('success', 'Akun Berhasil dibuat');
    }
}
