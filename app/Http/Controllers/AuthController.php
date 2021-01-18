<?php

namespace App\Http\Controllers;

use App\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $http = new \GuzzleHttp\Client;
        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'password',
                    'client_id' => config('services.passport.client_id'),
                    'client_secret' => config('services.passport.client_secret'),
                    'username' => $request->username,
                    'password' => $request->password,
                ]
            ]);
            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            $error = json_decode($error,true);
            $error = $error['error'];
                if ($error === 'invalid_grant') {
                    return response()->json('Wprowadzono niepoprawne dane.', 401);
                } else if ($error === 'invalid_request') {
                    return response()->json('Nie wprowadzono wszystkich wymaganych informacji.', 400);
                }
            return response()->json('Błąd serwera. Spróbuj ponownie później.', $e->getCode());
        }
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        return User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
    public function logout()
    {
        Auth::user()->tokens->each(function ($token, $key) {
            $token->delete();
        });
        return response()->json('Logged out successfully', 200);
    }
    public function googleLogin(Request $request)
    {
        $http = new Client;
        try {
            $response = $http->post(config('services.passport.login_endpoint'), [
                'form_params' => [
                    'grant_type' => 'social',
                    'client_id' => env('PASSPORT_CLIENT_ID'),
                    'client_secret' => env('PASSPORT_CLIENT_SECRET'),
                    'provider' => 'google',
                    'access_token' => $request->access_token,
                ]
            ]);
            return $response->getBody();
        } catch (\GuzzleHttp\Exception\BadResponseException $e) {
            $error = $e->getResponse()->getBody()->getContents();
            return $error;
            $error = json_decode($error,true);
            $error = $error['error'];
            if ($error === 'invalid_grant') {
                return response()->json('Wprowadzono niepoprawne dane.', 401);
            } else if ($error === 'invalid_request') {
                return response()->json('Nie wprowadzono wszystkich wymaganych informacji.', 400);
            }
            return response()->json('Błąd serwera. Spróbuj ponownie później.', $e->getCode());
        }
    }
}
