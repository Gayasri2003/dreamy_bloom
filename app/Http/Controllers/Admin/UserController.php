<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $user->load('orders');
        return view('admin.users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'role' => 'required|in:admin,customer',
        ]);

        $user->update($validated);
        return redirect()->route('admin.users.index')->with('success', 'User role updated successfully!');
    }
}
