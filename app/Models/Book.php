<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['isbn', 'name', 'url', 'poster', 'price'];

    public $timestamps = false;

    /**
     * @return BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * @param int $tagId
     * @return bool
     */
    public function hasTag(int $tagId): bool
    {
        return $this->tags->contains('id', '=', $tagId);
    }
}