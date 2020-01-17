<?php

namespace App\Controllers;

use App\Models\Book;
use App\Models\Tag;
use Src\Helpers\Cookie;
use Src\Helpers\Router;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class FiltersController extends AbstractController
{
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
            $books = Book::filterByTags($options['filters'], $books);
        }

        if (Cookie::has('books_sort')) {
            $options = Cookie::getUnserialized('books_sort');
            $books = Book::sortBy($options['sort_by'], $options['order'], $books);
        }

        echo $this->twig->render('books/filters/index.twig', [
            'books' => $books,
            'tags' => $tags,
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

            Cookie::set('books_filter', ['filters' => $filterTags]);

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