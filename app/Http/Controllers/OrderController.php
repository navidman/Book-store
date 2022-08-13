<?php

namespace App\Http\Controllers;

use App\Facades\OrderFacade;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'title' => ['required', 'string'],
            'book_number' => ['required', 'string', 'size:10'],
            'amount' => ['required', 'min:1'],
        ]);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        try {
            $order = OrderFacade::orderBook($data);
            return $order;
        } catch (\Throwable $throwable) {
            report($throwable);
        }
    }
}
