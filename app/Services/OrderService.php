<?php

namespace App\Services;

use App\Jobs\OrderAccountingJob;
use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function orderBook($data)
    {
        $user = Auth::user();
        $book = Book::whereBookNumber($data['book_number'])->first();
        $is_book_available = $this->checkBookIsAvailable($book->quantity, $data['amount']);
        if (!$is_book_available) {
            return response('کتاب مورد نظر موجود نیست', 400);
        }
        $payment = $this->payment($book, $data, $user);
        if (!$payment) {
            return response('پرداخت ناموفق', 400);
        }
        $order = $this->createOrder($user, $book, $data);
        return response(['data' => $order], Response::HTTP_OK);
    }

    private function checkBookIsAvailable($book_quantity, $amount)
    {
        if ($book_quantity >= $amount) {
            return true;
        }
        return false;
    }

    private function payment($book, $data, $user)
    {
        return true;
    }

    private function createOrder($user, $book, $data)
    {
        DB::beginTransaction();
        $order = Order::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'order_number' => $this->randomString(),
            'quantity' => $data['amount'],
            'price' => $book->price * $data['amount'],
            'book' => $book,
        ]);
        $book = Book::whereBookNumber($data['book_number'])->update([
            'quantity' => $book->quantity - $data['amount']
        ]);
        DB::commit();
        dispatch(new OrderAccountingJob($user->id, $order->price));
        return $order;
    }

    private function randomString($length = 10, $strtoupper = true) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        if ($strtoupper) {
            return strtoupper($randomString);
        }
        return $randomString;
    }
}
