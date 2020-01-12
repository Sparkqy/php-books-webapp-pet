<?php

namespace App\Controllers\Books;

use App\Controllers\AbstractController;
use App\Models\Book;
use Src\Helpers\Cookie;
use Src\Helpers\Router;
use Src\Services\Filter\Filter;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class FiltersController extends AbstractController
{
    /**
     * @var array
     */
    protected $books = [];

    /**
     * @var Filter
     */
    private $filter;

    public function __construct()
    {
        parent::__construct();

        $this->books = Book::all();
        $this->filter = new Filter($this->books);
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index()
    {
        $booksTags = Book::getTags($this->books);

        if (Cookie::has('books_filter')) {
            $sortOptions = Cookie::getUnserialized('books_filter');
            $this->filter->whereKeyHasValue($sortOptions['filter_by'], $sortOptions['filters']);
        }

        if (Cookie::has('books_sort')) {
            $sortOptions = Cookie::getUnserialized('books_sort');
            $this->filter->sortByKey($sortOptions['sort_by'], $sortOptions['order']);
        }

        echo $this->twig->render('books/filters/index.twig', [
            'books' => empty($this->filter->getOutputData()) ? $this->books : $this->filter->getOutputData(),
            'booksTags' => $booksTags,
        ]);
    }

    public function filterByTags(): void
    {
        if (isset($_POST['submit_filter_by_tags'])) {
            $filterTags = (array)$_POST['filter_tags'];

            if (empty($filterTags)) {
                Router::redirectWithFlash('error', [
                    'message' => 'Choose at least one tag to filter books',
                    'class' => 'alert-danger',
                ], '/books/filters');
            }

            Cookie::set('books_filter', ['filter_by' => 'tags', 'filters' => $filterTags]);

            Router::redirectWithFlash('success', [
                'message' => 'Books was successfully filtered by tags',
                'class' => 'alert-success',
            ], '/books/filters');
        }
    }

    public function sortByPrice(): void
    {
        if (isset($_POST['submit_filter_by_price'])) {
            $order = (string)$_POST['filter_price'];

            if ($order !== 'ASC' && $order !== 'DESC') {
                Router::redirectWithFlash('error', [
                    'message' => 'Sort order can be ASC or DESC only',
                    'class' => 'alert-danger',
                ], '/books/filters');
            }

            Cookie::set('books_sort', ['sort_by' => 'price', 'order' => $order]);

            Router::redirectWithFlash('success', [
                'message' => 'Books was successfully filtered by price in ' . $order . ' order',
                'class' => 'alert-success',
            ], '/books/filters');
        }
    }

    public function sortByName(): void
    {
        if (isset($_POST['submit_filter_by_name'])) {
            $order = (string)$_POST['filter_name'];

            if ($order !== 'ASC' && $order !== 'DESC') {
                Router::redirectWithFlash('error', [
                    'message' => 'Sort order can be ASC or DESC only',
                    'class' => 'alert-danger',
                ], '/books/filters');
            }

            Cookie::set('books_sort', ['sort_by' => 'name', 'order' => $order]);

            Router::redirectWithFlash('success', [
                'message' => 'Books was successfully filtered by name in ' . $order . ' order',
                'class' => 'alert-success',
            ], '/books/filters');
        }
    }
}