<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['email', 'first_name', 'last_name', 'password', 'is_admin'];

    /**
     * @var array
     */
    protected $casts = ['is_admin' => 'boolean'];
}