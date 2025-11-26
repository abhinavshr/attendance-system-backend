<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function allUsers()
    {
        return User::with('role')->get();
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password),
            'role_id'=> $request->role_id,
        ]);

        return response()->json(['message'=>'User created successfully', 'user'=>$user]);
    }
}
