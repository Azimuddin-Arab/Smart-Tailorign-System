<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // public function index()
    // {
    //     return User::all();
    // }
public function index()
{
    // if (auth()->user()->role !== 'admin') {
    //     return response()->json(['message' => 'Access denied. Admins only.'], 403);
    // }

    // return User::all();
        $users = User::select('id', 'name', 'email')->get(); // remove role
    return response()->json([
        'status' => 'success',
        'data' => $users
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users',
            'password'=>'required|string|min:6',
            'role'=>'required|string'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'role'=>$request->role
        ]);

        return response()->json($user,201);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'=>'required|string',
            'email'=>'required|email|unique:users,email,'.$id,
            'role'=>'required|string'
        ]);

        $user->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'role'=>$request->role,
            'password'=>$request->password ? Hash::make($request->password) : $user->password
        ]);

        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message'=>'User deleted']);
    }
}
