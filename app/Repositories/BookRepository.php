<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class BookRepository extends AbstractRepository
{
    /**
     * @param string $searchQuery
     * @param string $searchColumn
     * @return array
     */
    public function search(string $searchQuery, string $searchColumn): array
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
    public function filterByTags(array $filters, Collection $collection = null): Collection
    {
        if ($collection !== null) {
            $filtered = collect([]);

            foreach ($collection as $collectionItem) {
                if ($collectionItem instanceof Book) {
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

        return Book::whereHas('tags', function (Builder $query) use ($filters) {
            $query->whereIn('id', $filters);
        })->get();
    }

    /**
     * @param string $sortableColumn
     * @param string $order
     * @param Collection|null $collection
     * @return array
     */
    public function sortBy(string $sortableColumn, string $order, Collection $collection = null): array
    {
        if ($collection !== null) {
            if ($order === $this->sortOrders['asc']) {
                $sorted = $collection->sortBy($sortableColumn);
            } elseif ($order === $this->sortOrders['desc']) {
                $sorted = $collection->sortByDesc($sortableColumn);
            } else {
                throw new InvalidArgumentException('Order string must equal to ASC or DESC');
            }

            return $sorted->values()->all();
        }

        return Book::orderBy($sortableColumn, $order)->get();
    }
}