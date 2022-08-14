<?php

namespace App\Http\Controllers;

use App\Facades\AccountingFacade;
use Illuminate\Http\Response;

class AccountingController extends Controller
{
    public function index()
    {
        try {
            $accountings = AccountingFacade::getAccounting();
            return response(['data' => $accountings], Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            report($throwable);
            return response('در سمت سرور خطایی رخ داده است.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
