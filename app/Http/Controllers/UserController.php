<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Validator;
use Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $rules = array(
            'email' => 'required|email|max:191|unique:users',
            'password' => 'required|string|max:20|confirmed',
            'name' => 'required|string|max:191',
        );
        
        $data = $request->validate($rules);
        $user = new User;
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();
        
        $token = $user->createToken($data['name'] . 'Sign up')->plainTextToken;
        return response(
            [
                'status' => 201,
                'message' => "Sign up Successful",
                'token' => $token,
                'username' => $user->name,
                'role' => $user->role
            ],
            201
        );
    }

    public function login(Request $request)
    {
        $rules = array(
        'email' => 'required|email|max:191',
        'password' => 'required|string|max:191',
        );
        $data = $request->validate($rules);
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response(['error' => 'The provided credentials are incorrect.'], 422);
        }

        $token = $user->createToken($user->name . 'Logs in')->plainTextToken;

        return response(
            [
            'status' => 200,
            'message' => "Login Successful",
            'token' => $token,
            'username' => $user->name,
            'role' => $user->role
            ],
            200
        );
    }
}
