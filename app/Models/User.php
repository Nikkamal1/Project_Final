<?php
// app/Models/User.php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'is_admin', 'is_staff', 'is_active',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_admin' => 'integer',
        'is_staff' => 'integer',
        'is_active' => 'integer',
    ];
}
