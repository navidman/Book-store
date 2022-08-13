<?php

namespace App\Http\Controllers;

use App\Facades\PaymentFacade;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function payment(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'amount' => ['required', 'integer'],
            'iban' => ['required', 'string'],
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        try {
            $payment = PaymentFacade::payment($data);
            return $payment;
        } catch (\Throwable $throwable) {
            report($throwable);
        }
    }
}
