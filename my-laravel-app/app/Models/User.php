<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Method to get the identifier for JWT
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    // Method to get custom claims for JWT (optional)
    public function getJWTCustomClaims()
    {
        return [];
    }
}
