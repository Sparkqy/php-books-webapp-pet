<?php

namespace Src\Services\Search;

class Search
{
    protected $searchable;

    /**
     * Search constructor.
     * @param array $searchable
     */
    public function __construct(array $searchable)
    {
        $this->searchable = $searchable;
    }

    /**
     * @param string $searchQuery
     * @param string $searchKey
     * @return array|null
     */
    public function whereKeyPropertyLike(string $searchKey, string $searchQuery): ?array
    {
        $result = null;

        foreach ($this->searchable as $item) {
            if (array_key_exists($searchKey, $item) && is_string($item[$searchKey])) {
                if (stripos($item[$searchKey], $searchQuery) !== false) {
                    $result[] = $item;
                    continue;
                }
            }
        }

        return $result;
    }
}