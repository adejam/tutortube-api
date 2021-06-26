<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Auth;
use Illuminate\Database\QueryException;

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
                'username' => $user->name
            ],
            201
        );
    }
}
