<?php

namespace App\Services;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

class AuthService
{
    public function token($user, $request)
    {
        $client = Client::where('password_client', 1)->first();
        $request->request->add([
            "grant_type" => "password",
            "username" => $request->email,
            "password" => $request->password,
            "client_id" => $client->id,
            "client_secret" => $client->secret,
            'scope' => null,
        ]);
        $tokenRequest = $request->create(
            '/oauth/token',
            'post'
        );
        $instance = Route::dispatch($tokenRequest);
        $tokenInfo = json_decode($instance->getContent(), true);
        $tokenInfo = collect($tokenInfo);

        if ($tokenInfo->has('error')) {
            return response(['message' => 'کاربر غیر مجاز است', 'status' => 401], 401);
        }
        $user_info = [
            'name' => $user->name,
            'email' => $user->email,
            'mobile' => $user->mobile,
        ];
        $tokenInfo['user'] = $user_info;

        return $tokenInfo;
    }

    public function revoke()
    {
        $user = Auth::user();
        $user->token()->revoke();
        return true;
    }
}
