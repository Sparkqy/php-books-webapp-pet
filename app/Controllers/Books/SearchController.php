<?php

namespace App\Controllers\Books;

use App\Controllers\AbstractController;
use App\Models\Book;
use Exception;
use Src\Helpers\Router;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SearchController extends AbstractController
{
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws Exception
     */
    public function index(): void
    {
        $books = Book::with('tags')->get();

        if (isset($_GET['search_query'])) {
            try {
                list($searchQuery, $searchResult) = Book::search($_GET['search_query'], 'name');
            } catch (\InvalidArgumentException $e) {
                Router::redirectWithFlash('error', [
                    'message' => 'Search query cannot be empty',
                    'class' => 'alert-danger',
                ], '/books/search');
            }
        }

        echo $this->twig->render('books/search/index.twig', [
            'books' => $books,
            'searchQuery' => $searchQuery ?? null,
            'searchResult' => $searchResult ?? null,
        ]);
    }
}