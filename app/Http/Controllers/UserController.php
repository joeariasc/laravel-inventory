<?php

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Helpers\Utilities;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', [
            'users' => $users
        ]);
    }

    public function create()
    {
        return view('users.form', [
            'user' => new User(),
            'roles' => UserRole::cases(),
        ]);
    }

    public function store(UserRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('photo')) {
            $image = Utilities::uploadFile('photo', '/public/users');
            $data['photo'] = $image;
        }

        if (empty($data['password'])) {
            $data['password'] = Hash::make($data['personal_id']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        User::create($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'New User has been created!');
    }

    public function show(User $user)
    {
        return view('users.show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return view('users.form', [
            'user' => $user,
            'roles' => UserRole::cases(),
        ]);
    }

    public function update(UserRequest $request, User $user)
    {

        $data = $request->validated();

        if ($request->hasFile('photo')) {
            // Delete the old photo if exists
            Utilities::deleteFile('/public/users', $user->photo);
            $image = Utilities::uploadFile('photo', '/public/users');
            $data['photo'] = $image;
        }

        if (empty($data['password'])) {
            $data['password'] = Hash::make($data['personal_id']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('users.index')
            ->with('success', 'User has been updated!');
    }

    public function updatePassword(Request $request, string $username)
    {
        # Validation
        $validated = $request->validate([
            'password' => 'required_with:password_confirmation|min:6',
            'password_confirmation' => 'same:password|min:6',
        ]);

        # Update the new Password
        User::where('username', $username)->update([
            'password' => Hash::make($validated['password'])
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User has been updated!');
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()
                ->route('users.index')
                ->with('success', 'User has been deleted!');
        } catch (\Exception) {
            return redirect()
                ->route('users.index')
                ->with('success', 'Failed try to delete the user');
        }
    }
}
