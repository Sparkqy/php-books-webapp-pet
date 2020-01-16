<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['email', 'first_name', 'last_name', 'password', 'auth_token', 'is_admin'];

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $casts = ['is_admin' => 'boolean'];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * @throws Exception
     */
    public function refreshHash(): self
    {
        $this->auth_token = sha1(random_bytes(100));
        $this->save();

        return $this;
    }

    /**
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
}