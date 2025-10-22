<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // List users with optional filter
    public function index(Request $request)
    {
        $filter = $request->input('filter');

        $users = User::when($filter, function($query, $filter){
            return $query->where('name','like',"%$filter%")
                         ->orWhere('email','like',"%$filter%");
        })->get(); // fetch all fields including phone & role

        return view('users.index', compact('users', 'filter'));
    }

    // Show create form
    public function create()
    {
        return view('users.create');
    }

    // Store new user
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|max:50',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
            'password' => Hash::make('default123')
        ]);

        return redirect()->route('users.index')->with('success','User added successfully');
    }

    // Show edit form
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Update user
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'role' => 'required|string|max:50',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success','User updated successfully');
    }

    // Delete user
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success','User deleted successfully');
    }
}
