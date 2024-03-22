<?php

namespace App\Http\Controllers;

use App\Events\Register;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function register(Request $request)
    {
        User::create([
            'first_name' => $request->f_name,
            'last_name' => $request->l_name,
            'phone_number' => $request->p_number,
            'password' => $request->pass
        ]);
        return response()->json([
            'status' => true,
            'message' => 'ok'
        ]);
    }
}
