<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Check if current user can manage users (Owner or Admin only)
     */
    private function authorizeUserManagement()
    {
        $userRole = auth()->user()?->role;
        if (!in_array($userRole, ['owner', 'admin'])) {
            abort(403, 'Unauthorized access to user management');
        }
    }

    /**
     * Check if current user can view/edit a specific user
     */
    private function authorizeViewUser(User $user)
    {
        $authUser = auth()->user();

        // Owner and Admin can view/edit any user
        if (in_array($authUser->role, ['owner', 'admin'])) {
            return true;
        }

        // User can only view/edit their own profile
        if ($authUser->id === $user->id) {
            return true;
        }
        abort(403, 'Unauthorized access');
    }

    /**
     * Check if current user can edit a specific user
     */
    private function authorizeEditUser(User $user)
    {
        $authUser = auth()->user();

        // Owner can edit any user
        if ($authUser->role === 'owner') {
            return true;
        }

        // Admin can edit any user except owner
        if ($authUser->role === 'admin' && $user->role !== 'owner') {
            return true;
        }

        // User can edit their own profile
        if ($authUser->id === $user->id) {
            return true;
        }

        abort(403, 'Unauthorized access');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorizeUserManagement();

        return view('users.index', [
            'title' => 'Users',
            'users' => User::paginate(10)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorizeUserManagement();

        return view('users.create', [
            'title' => 'Create User',
            'roles' => ['owner' => 'Owner', 'admin' => 'Admin', 'courier' => 'Courier', 'customer' => 'Customer']
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorizeUserManagement();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:owner,admin,courier,customer',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        // Hash password before storing
        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')
                         ->with('success', 'User added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id);
        $this->authorizeViewUser($user);

        return view('users.show', [
            'title' => 'User Details',
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $this->authorizeEditUser($user);

        $authUser = auth()->user();
        $roles = ['owner' => 'Owner', 'admin' => 'Admin', 'courier' => 'Courier', 'customer' => 'Customer'];

        // Remove 'owner' role option if current user is not owner
        if ($authUser->role !== 'owner') {
            unset($roles['owner']);
        }

        return view('users.edit', [
            'title' => 'Edit User',
            'user' => $user,
            'roles' => $roles,
            'canChangeRole' => in_array($authUser->role, ['owner', 'admin'])
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $this->authorizeEditUser($user);

        $authUser = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'role' => 'required|in:owner,admin,courier,customer',
            'phone_number' => 'nullable|string|max:15',
            'address' => 'nullable|string',
        ]);

        // Only allow role change if user is owner or admin
        if ($authUser->role !== 'owner' && $authUser->id !== $user->id) {
            // User can change their own role only if they're already owner/admin
            $validated['role'] = $user->role;
        } elseif ($authUser->role === 'admin' && $user->role === 'owner') {
            // Admin cannot change owner's role
            $validated['role'] = $user->role;
        } elseif ($authUser->id === $user->id && $authUser->role !== 'owner') {
            // User editing own profile cannot change role unless they're owner
            $validated['role'] = $user->role;
        }

        // Only hash password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')
                         ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->authorizeUserManagement();

        $user = User::findOrFail($id);

        // Prevent deleting owner users (unless current user is owner)
        $authUser = auth()->user();
        if ($user->role === 'owner' && $authUser->id !== $user->id) {
            return redirect()->route('users.index')
                             ->with('error', 'Cannot delete owner users.');
        }

        // Prevent deleting own account
        if ($authUser->id === $user->id) {
            return redirect()->route('users.index')
                             ->with('error', 'Cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('users.index')
                         ->with('success', 'User deleted successfully.');
    }
}
