<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Role;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function listUsers()
    {
        $users = User::with('roles')->where('id', "!=", auth()->user()->id)->where('is_super_admin', 0)->get();
        return view('users.index', compact('users'));
    }

    public function createUser()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'is_active' => 'required|boolean',
            'role_id' => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.index')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->is_active,
            'password' => Hash::make('123456'),
        ]);

        if ($request->role_id) {
            $user->syncRoles([$request->role_id]);
        }

        DB::commit();

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function showUser(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function editUser(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function updateUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'is_active' => 'required|boolean',
            'role_id' => 'exists:roles,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('users.edit', $user)
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_active' => $request->is_active,
        ]);

        $user->roles()->detach();
        if ($request->role_id) {
            $user->syncRoles([$request->role_id]);
        }

        DB::commit();

        return redirect()->route('users.index', $user)->with('success', 'User updated successfully.');
    }

    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }

    public function showResetPasswordForm()
    {
        return view('users.reset-password');
    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.showResetPasswordForm')
                ->withErrors($validator)
                ->withInput();
        }

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('profile.showResetPasswordForm')
                ->withErrors(['current_password' => 'Current password is incorrect'])
                ->withInput();
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.showResetPasswordForm')->with('success', 'Password reset successfully.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Logged out successfully.');
    }

    public function showProfile()
    {
        $user = Auth::user();
        return view('profile.showProfile', compact('user'));
    }
}
