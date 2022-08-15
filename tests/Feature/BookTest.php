<?php

namespace Tests\Feature;

use App\Facades\BookFacade;
use Tests\TestCase;

class BookTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_books_response()
    {
        $books = [
            [
            "id" => 1,
            "title" => "Cristopher Romaguera",
            "price" => "39908",
            "quantity" => 37,
            "created_at" => "2022-08-10T17:12:25.000000Z",
            "updated_at" => "2022-08-10T17:12:25.000000Z",
            "deleted_at" => null
            ]
        ];
        BookFacade::shouldReceive('getBookList')->once()->andReturn($books);

        $response = $this->withoutMiddleware()->get('/api/books');

        $response->assertStatus(200);
    }
}
