<?php

namespace Src\Services\Filter;

use InvalidArgumentException;

class Filter
{
    /**
     * @var array
     */
    protected array $filterable = [];

    /**
     * @var array
     */
    protected array $filtered = [];

    /**
     * @var array
     */
    protected array $orders = [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ];

    /**
     * Filter constructor.
     * @param array $filterable
     */
    public function __construct(array $filterable)
    {
        $this->filterable = $filterable;
    }

    /**
     * @param string $filterableKey
     * @param array $filters
     * @return array
     */
    public function whereKeyHasValue(string $filterableKey, array $filters): array
    {
        $filtered = [];

        foreach ($this->getFilterable() as $filterableItem) {
            if (array_key_exists($filterableKey, $filterableItem)) {
                if (is_array($filterableItem[$filterableKey])) {
                    foreach ($filterableItem[$filterableKey] as $item) {
                        if (in_array($item, $filters)) {
                            $filtered[] = $filterableItem;
                            continue 2;
                        }
                    }
                }
            }
        }

        $this->setFiltered($filtered);

        return $filtered;
    }

    /**
     * @param string $value
     * @param array $filters
     * @return bool
     */
    public static function isValueInFilter(string $value, array $filters): bool
    {
        return in_array($value, $filters);
    }

    /**
     * @param string $filterableKey
     * @param string $order
     * @return array
     */
    public function sortByKey(string $filterableKey, string $order = 'ASC'): array
    {
        $filterable = $this->getFilterable();

        if ($order === $this->orders['asc']) {
            usort($filterable, function (array $item1, array $item2) use ($filterableKey, $order) {
                if (array_key_exists($filterableKey, $item1) && array_key_exists($filterableKey, $item2)) {
                    return $item1[$filterableKey] <=> $item2[$filterableKey];
                }
            });
        } elseif ($order === $this->orders['desc']) {
            usort($filterable, function (array $item1, array $item2) use ($filterableKey, $order) {
                if (array_key_exists($filterableKey, $item1) && array_key_exists($filterableKey, $item2)) {
                    return $item2[$filterableKey] <=> $item1[$filterableKey];
                }
            });
        } else {
            throw new InvalidArgumentException('Order string must equal to ASC or DESC');
        }

        $this->setFiltered($filterable);
        
        return $filterable;
    }

    /**
     * @param array $filteredArray
     */
    private function setFiltered(array $filteredArray): void
    {
        $this->filtered = $filteredArray;
    }

    /**
     * @return array
     */
    private function getFilterable(): array
    {
        if (!empty($this->filtered)) {
            return $this->filtered;
        }

        return $this->filterable;
    }

    /**
     * @return array
     */
    public function getOutputData(): array
    {
        return $this->filtered;
    }
}