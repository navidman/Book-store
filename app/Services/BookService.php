<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function getBookList()
    {
        $books = Book::all();
        return $books;
    }
}
