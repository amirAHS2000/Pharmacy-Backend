<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    function login(Request $request)
    {
        $user = User::where('phone', $request->phone)->first();
        // print_r($data);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => ['These credentials do not match our records.']
            ], 404);
        }

        $token = $user->createToken('pharmacy-token')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }

    function register(Request $request)
    {
        $val = validator($request->all(), [
            'name' => 'required',
            'phone' => 'required|numeric',
            'password' => 'required|min:8'
        ]);

        if (!$val->fails()) {
            $user = new User();
            $user->fill([
                'name' => $request['name'],
                'phone' => $request['phone'],
                'password' => Hash::make($request['password']),
            ]);
            $user->save();
            $token = $user->createToken('pharmacy-token')->plainTextToken;
            return response()->json(['user' => $user, 'token' => $token]);
        } else {
            return response()->json(['error' => $val->errors()]);
        }

    }
}
