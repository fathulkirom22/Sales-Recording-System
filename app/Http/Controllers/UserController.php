<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(): View
    {
        // Datatables list + roles
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create(): View
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        // create user + assign role
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,staff',
        ]);

        $newUser = new User();
        $newUser->fill($validated);
        $newUser->setAttribute('password', bcrypt($validated['password']));
        $newUser->assignRole($validated['role']);
        $newUser->save();

        return redirect()->route('users.index')->with('success', 'User created successfully.', ['user' => $newUser]);
    }

    public function show(User $user): View
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user): View
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // update name, email, password, roles
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'. $user->id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:admin,staff',
        ]);

        $firstRole = $user->getRoleNames()->first();

        $user->fill(array_filter($validated, fn($value) => $value !== null));
        if ($validated['password']) {
            $user->setAttribute('password', bcrypt($validated['password']));
        }
        $user->removeRole($firstRole);
        $user->assignRole($validated['role']);
        $user->save();

        return redirect()->route('users.index')->with('success', 'User updated successfully.', ['user' => $user]);
    }

    public function destroy(User $user)
    {
        // delete user
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
