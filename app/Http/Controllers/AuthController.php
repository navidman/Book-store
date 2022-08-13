<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\Client;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'string', 'min:3', 'max:90'],
            'password' => ['required', 'min:8'],
        ]);

        if ($validator->fails()) {
            return response(responseError('', $validator->errors()), 400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            $validator->errors()->add('email', 'ایمیل وارد شده یافت نشد');

            return response($validator->errors(), 400);
        }
        if (!config('app.debug') or $user->checkPassword($request->password)) {
            $client = Client::where('password_client', 1)->first();
            $request->request->add([
                "grant_type"    => "password",
                "username"      => $request->email,
                "password"      => $request->password,
                "client_id"     => $client->id,
                "client_secret" => $client->secret,
                'scope'         => null,
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

            return response($tokenInfo, 200);
        } else {
            $validator->errors()->add('code', 'رمز عبور وارد شده معتبر نمی باشد');

            return response(responseError($validator->errors(), 401), 401);
        }
    }

    public function revoke()
    {
        $user = Auth::user();
        $user->token()->revoke();
        return response(responseSuccess('با موفقیت خارج شدید'), 200);
    }
}
