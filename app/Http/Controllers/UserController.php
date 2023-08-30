<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function store(Request $request)
    {
        $user = new User();
        $user->username = $request->username;
        $user->role = 'pegawai';
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'User created successfully']);
    }

    public function update(Request $request, User $user)
    {
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['message' => 'User updated successfully']);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
