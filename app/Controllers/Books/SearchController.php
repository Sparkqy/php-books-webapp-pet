<?php

namespace App\Controllers\Books;

use App\Controllers\AbstractController;
use App\Models\Book;
use Exception;
use Src\Helpers\Router;
use Src\Services\Search\Search;
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
    public function index()
    {
        $books = Book::all();

        if (isset($_GET['search_query'])) {
            list($searchQuery, $searchResult) = $this->search($books, $_GET['search_query']);
        }

        echo $this->twig->render('books/search/index.twig', [
            'books' => $books,
            'searchQuery' => $searchQuery ?? null,
            'searchResult' => $searchResult ?? null,
        ]);
    }

    /**
     * @param array $data
     * @param string $searchQuery
     * @return array
     * @throws Exception
     */
    public function search(array $data, string $searchQuery): array
    {
        $searchQuery = trim(filter_var($searchQuery, FILTER_SANITIZE_STRING)) ?? null;

        if (empty($searchQuery)) {
            Router::redirectWithFlash('error', [
                'message' => 'Search query cannot be empty',
                'class' => 'alert-danger',
            ], '/books/search');
        }

        $search = new Search($data);
        $searchResult = $search->whereKeyPropertyLike('name', $searchQuery);

        return [$searchQuery, $searchResult];
    }
}