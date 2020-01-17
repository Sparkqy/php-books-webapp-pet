<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;

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

    /**
     * @param string $searchQuery
     * @param string $searchColumn
     * @return array
     */
    public static function search(string $searchQuery, string $searchColumn): array
    {
        try {
            $searchResult = Book::where($searchColumn, 'like', '%' . $searchQuery . '%')->get();
        } catch (\PDOException $e) {
            echo $e->getMessage();
            exit();
        }

        return [$searchQuery, $searchResult];
    }

    /**
     * @param array $filters
     * @param Collection|null $collection
     * @return Collection
     */
    public static function filterByTags(array $filters, Collection $collection = null): Collection
    {
        if ($collection !== null) {
            $filtered = collect([]);

            foreach ($collection as $collectionItem) {
                if ($collectionItem instanceof self) {
                    /** @var Tag $tag */
                    foreach ($collectionItem->tags as $tag) {
                        if (in_array($tag->id, $filters)) {
                            $filtered->push($collectionItem);
                            continue 2;
                        }
                    }
                }
            }

            return $filtered;
        }

        return self::whereHas('tags', function (Builder $query) use ($filters) {
            $query->whereIn('id', $filters);
        })->get();
    }

    /**
     * @param string $sortableColumn
     * @param string $order
     * @param Collection|null $collection
     * @return array
     */
    public static function sortBy(string $sortableColumn, string $order, Collection $collection = null)
    {
        if ($collection !== null) {
            if ($order === 'ASC') {
                $sorted = $collection->sortBy($sortableColumn);
            } elseif ($order === 'DESC') {
                $sorted = $collection->sortByDesc($sortableColumn);
            } else {
                throw new InvalidArgumentException('Order string must equal to ASC or DESC');
            }

            return $sorted->values()->all();
        }

        return self::orderBy($sortableColumn, $order)->get();
    }
}