<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function getBookList()
    {
        return Book::all();
    }
}
