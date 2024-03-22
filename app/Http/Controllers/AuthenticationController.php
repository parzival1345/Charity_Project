<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthenticationController extends Controller
{
    public function register(RegisterRequest $request)
    {
        User::create([
            'first_name' => $request->f_name,
            'last_name' => $request->l_name,
            'phone_number' => $request->p_number,
            'email' => $request->email,
            'password' => Hash::make($request->pass)
        ]);
        return response()->json([
            'status' => true,
            'message' => 'ok'
        ]);
    }
}
