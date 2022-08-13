<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
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
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'book_number' => $this->randomString(),
            'price' => rand(10000, 50000),
            'quantity' => rand(0, 100),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
