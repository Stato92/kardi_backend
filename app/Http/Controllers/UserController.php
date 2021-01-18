<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'string|min:2|max:255',
            'surname' => 'string|min:2|max:255',
            'clinic' => 'required|in:nacz,kardio'
        ]);
        $user = Auth::user();
        $user->clinic = $request->clinic;
        !empty($request->phone_numbers)?$user->phone_numbers = $request->phone_numbers:null;
        $user->save();
        return response()->json('Profile updated', 200);
    }
}
