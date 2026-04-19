<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Mockery\Generator\StringManipulation\Pass\Pass;

class ApiController extends Controller
{
    //Register API [name, email, password, password_confirm]
    public function register(Request $request)
    {
        $data = $request->validate([
            "name" => "required|string",
            "email" => "required|email|unique:users,email",
            "password" => "required|confirmed"
        ]);

        User::create($data);

        return response()->json([
            "status" => true,
            "message" => "created successfuly",
        ]);
    }

    // Login [name, password]
    public function login(Request $request)
    {
        $data = $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        //ignore o erro e apenas da extensao intelisense
        $token = auth()->attempt($data);

        if ($token) {
            return response()->json([
                "status" => true,
                "message" => "User Logged in",
                "token" => $token
            ]);
        }
        else{
            return response()->json([
                "status" => false,
                "message" => "Invalid Credentials",
            ]);
        }
    }

    // Profile API
    public function profile() {
        $data = auth()->user();

        return response()->json([
            "status" => true,
            "message" => "User Data",
            "data" => $data
        ]);
    }

    // Refresh Token API
    public function refreshToken() {
        $newToken = auth()->refresh();

        return response()->json([
            "status" => true,
            "message" => "New Token",
            "new-token" => $newToken
        ]);
    }

    // Logout
    public function logout() {
        auth()->logout();

        return response()->json([
            "status" => true,
            "message" => "User logged out"
        ]);
    }
}
