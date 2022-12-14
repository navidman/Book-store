<?php

namespace App\Http\Controllers;

use App\Facades\BookFacade;
use Illuminate\Http\Response;

class BookController extends Controller
{
    public function index()
    {
        try {
            $books = BookFacade::getBookList();
            return response(['data' => $books], Response::HTTP_OK);
        } catch (\Throwable $throwable) {
            report($throwable);
            return response('در سمت سرور خطایی رخ داده است.', Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
