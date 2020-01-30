<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Tag;
use Src\Core\DI\DI;
use src\Exceptions\DIContainerException;
use Src\Helpers\Cookie;
use Src\Helpers\Router;
use stdClass;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class FiltersController extends AbstractController
{
    /**
     * @var stdClass
     */
    private stdClass $bookModel;

    /**
     * @var array
     */
    private array $sortOrders = [
        'asc' => 'ASC',
        'desc' => 'DESC',
    ];

    /**
     * FiltersController constructor.
     * @param DI $di
     * @throws DIContainerException
     */
    public function __construct(DI $di)
    {
        parent::__construct($di);
        $this->bookModel = $this->modelLoader->loadModel('book');
    }

    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index()
    {
        $books = Book::with('tags')->get();
        $tags = Tag::all();

        if (Cookie::has('books_filter')) {
            $options = Cookie::getUnserialized('books_filter');
            $books = $this->bookModel->repository->filterByTags($options['filters'], $books);
        }

        if (Cookie::has('books_sort')) {
            $options = Cookie::getUnserialized('books_sort');
            $books = $this->bookModel->repository->sortBy($options['sort_by'], $options['order'], $books);
        }

        echo $this->twig->render('books/filters/index.twig', [
            'books' => $books,
            'tags' => $tags,
        ]);
    }

    public function filterByTags(): void
    {
        if (isset($_POST['submit_filter_by_tags'])) {
            $validator = $this->validator->validate($_POST, ['filter_tags' => 'required']);

            if ($validator->hasErrors()) {
                Router::redirectWithFlash('error', [
                    'message' => $validator->echoErrors(),
                    'class' => 'alert-danger',
                ], '/books/filters');
            }

            $validData = $validator->get();
            Cookie::set('books_filter', ['filters' => $validData['filter_tags']]);

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

            if ($order !== $this->sortOrders['asc'] && $order !== $this->sortOrders['desc']) {
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

            if ($order !== $this->sortOrders['asc'] && $order !== $this->sortOrders['desc']) {
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