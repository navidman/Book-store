<?php

namespace App\Services;

use App\Jobs\PaymentAccountingJob;
use App\Models\Accounting;
use App\Models\Card;
use App\Models\Payment;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class PaymentService
{
    public function payment($data)
    {
        $userId = Auth::user()->id;
        $card = Card::whereUserId($userId)->whereIban($data['iban'])->first();
        if (!$card) {
            return response('شماره شبا یافت نشد', 400);
        }
        $toPay = Accounting::whereUserId($userId)->first()->to_pay;
        if ($data['amount'] > $toPay) {
            return response('مبلغ درخواستی بیشتر از موجودی شماست', 400);
        }
        $payment = $this->createPayment($userId, $data, $card->id);
        return response(['data' => $payment], Response::HTTP_OK);
    }

    private function createPayment($userId, $data, $cardId)
    {
        $payment = Payment::create([
            'user_id' => $userId,
            'card_id' => $cardId,
            'price'  => $data['amount']
        ]);
        dispatch(new PaymentAccountingJob($userId, $data['amount']));
        return $payment;
    }
}
