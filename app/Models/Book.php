<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['isbn', 'name', 'url', 'poster', 'price', 'tags'];
}