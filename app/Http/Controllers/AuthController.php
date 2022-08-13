<?php

namespace App\Http\Controllers;

use App\Facades\AuthFacade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

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
            try {
                $tokenInfo = AuthFacade::token($user, $request);
                return response($tokenInfo, 200);
            } catch (\Throwable $throwable) {
                report($throwable);
            }
        } else {
            $validator->errors()->add('code', 'رمز عبور وارد شده معتبر نمی باشد');
            return response($validator->errors(), 401);
        }
    }

    public function revoke()
    {
        try {
            AuthFacade::revoke();
            return response('با موفقیت خارج شدید', Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            report($throwable);
        }
    }
}
