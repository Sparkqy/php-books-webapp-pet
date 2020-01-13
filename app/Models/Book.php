<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['isbn', 'name', 'url', 'poster', 'price', 'tags'];

    /**
     * @var array
     */
    protected $casts = ['tags' => 'array'];

    /**
     * @return array|null
     */
    public static function allTags(): ?array
    {
        $books = self::where('tags', '!=', null)->get();

        if (empty($books)) {
            return null;
        }

        $bookTags = $books->pluck('tags')->toArray();
        $allTags = [];

        foreach ($bookTags as $tags) {
            foreach ($tags as $tag) {
                $allTags[] = $tag;
            }
        }

        return array_unique($allTags);
    }
}