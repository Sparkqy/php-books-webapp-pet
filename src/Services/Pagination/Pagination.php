<?php

namespace Src\Services\Pagination;

use Src\Exceptions\InappropriateTypeException;
use Src\Helpers\Router;

class Pagination
{
    /**
     * @var string
     */
    protected $baseUrl;

    /**
     * @var array
     */
    protected $paginatable;

    /**
     * @var int
     */
    protected $totalItemsQty;

    /**
     * @var int
     */
    protected $limit;

    /**
     * @var int
     */
    protected $totalPagesQty;

    /**
     * @var int
     */
    protected $currentPage;

    /**
     * Pagination constructor.
     * @param array $data
     * @param string $baseUrl
     */
    public function __construct(array $data, string $baseUrl)
    {
        $this->paginatable = $data;
        $this->baseUrl = $baseUrl;
        $this->totalItemsQty = count($data);
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        $currentPage = isset($_GET['page']) ? (int) $_GET['page'] : 1;

        if ($currentPage > $this->totalPagesQty) {
            Router::redirect($this->baseUrl . '?page=' . $this->totalPagesQty);
        }

        return $currentPage;
    }

    /**
     * @param int $page
     * @return bool
     */
    public function isCurrentPage(int $page): bool
    {
        return ($page === $this->getCurrentPage());
    }

    /**
     * @return int
     */
    public function getTotalPagesQty(): int
    {
        return ceil($this->totalItemsQty / $this->limit);
    }

    /**
     * @param int $limit
     * @return array
     * @throws InappropriateTypeException
     */
    public function paginate(int $limit): array
    {
        $this->setLimit($limit);
        $this->totalPagesQty = $this->getTotalPagesQty();
        $this->currentPage = $this->getCurrentPage();
        $offset = ($this->currentPage - 1) * $this->limit;

        return array_slice($this->paginatable, $offset, $this->limit);
    }

    /**
     * @param int $limit
     * @throws InappropriateTypeException
     */
    private function setLimit(int $limit): void
    {
        if ($limit === 0) {
            throw new InappropriateTypeException('Page limit cannot equals to zero');
        }

        $this->limit = $limit;
    }
}