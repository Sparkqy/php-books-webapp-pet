<?php

namespace Src\Services\Pagination;

use Src\Exceptions\FileNotFoundException;
use Src\Exceptions\InappropriateTypeException;
use Src\Helpers\Router;
use Src\Services\Validation\Validator;

class Paginator
{
    /**
     * @var string
     */
    protected string $baseUrl;

    /**
     * @var array
     */
    protected array $paginatable;

    /**
     * @var int
     */
    protected int $totalItemsQty;

    /**
     * @var int
     */
    protected int $limit;

    /**
     * @var int
     */
    protected int $totalPagesQty;

    /**
     * @var int
     */
    protected int $currentPage;

    /**
     * @var Validator
     */
    protected Validator $validator;

    /**
     * Paginator constructor.
     * @param array $data
     * @param string $baseUrl
     * @throws FileNotFoundException
     */
    public function __construct(array $data, string $baseUrl)
    {
        if (empty($data)) {
            throw new \InvalidArgumentException('Array being paginated cannot be empty');
        }

        $this->validator = new Validator();
        $this->paginatable = $data;
        $this->baseUrl = $baseUrl;
        $this->totalItemsQty = count($data);
    }

    /**
     * @param array $get
     * @return bool|int
     */
    private function validateCurrentPage(array $get)
    {
        if (empty($get['page'])) {
           return 1;
        }

        $validator = $this->validator->validate($get, ['page' => 'numeric']);

        if ($validator->hasErrors()) {
            return false;
        }

        return (int)$validator->get()['page'];
    }

    /**
     * @return int
     */
    public function getCurrentPage(): int
    {
        $currentPage = $this->validateCurrentPage($_GET);

        if ($currentPage === false || $currentPage > $this->totalPagesQty) {
            Router::redirect($this->baseUrl . '?page=' . $this->totalPagesQty);
        }

        return $currentPage;
    }

    /**
     * @param int $page
     * @return bool
     */
    public static function isCurrentPage(int $page): bool
    {
        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

        return ($page === $currentPage);
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