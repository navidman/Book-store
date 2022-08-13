<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'password'
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function checkPassword($password)
    {
        if ($this->password and Hash::check($password, $this->password)) {
            return true;
        }
        return false;
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function requests()
    {
        return $this->hasMany(Request::class);
    }
}
