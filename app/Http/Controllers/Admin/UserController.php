<?php

// UserController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Fetch all users from the database
        $users = User::paginate(10);

        // Pass the users data to the view
        return view('admin.users.index', compact('users'));
    }
    public function create()
    {
        return view('admin.users.create');
    }
    public function destroy(User $user)
    {
        // Delete the user
        $user->delete();

        // Redirect back with success message
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'phone_number' => 'required|string', // Add validation for phone number
        ]);

        // Create the new user
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone_number' => $request->input('phone_number'), // Add phone number field
        ]);

        // Redirect back to the user index page
        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8', // Add any password validation rules as needed
            'phone_number' => 'required|string', // Add validation for phone number
        ]);

        // Update the user information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'phone_number' => $request->phone_number, // Update phone number field
            // Add more fields for updating user information as needed
        ]);

        // Redirect back with success message
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }
}
