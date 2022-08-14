<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
                'name' => 'test',
                'email' => 'test@example.com',
                'mobile' => '09129120912',
                'zip_code' => rand(1000000000, 10000000000 - 1),
                'address' => 'test address',
                'email_verified_at' => now(),
                'password' => Hash::make('12345678'),
                'created_at' => now(),
                'updated_at' => now()
        ];
        $record = User::whereEmail($users['email'])->first();
        if (!$record) {
            $record = User::create($users);
        }
    }
}
