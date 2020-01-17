<?php

namespace App\Controllers;

use App\Models\Book;
use Exception;
use Src\Helpers\Router;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SearchController extends AbstractController
{
    /**
     * @var array
     */
    private $validationRules = ['search_query' => 'required'];

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
            $validator = $this->validator->validate($_GET, $this->validationRules);

            if ($validator->hasErrors()) {
                Router::redirectWithFlash('error', [
                    'message' => $validator->echoErrors(),
                    'class' => 'alert-danger',
                ], '/books/search');
            }

            $validData = $validator->get();
            list($searchQuery, $searchResult) = Book::search($validData['search_query'], 'name');
        }

        echo $this->twig->render('books/search/index.twig', [
            'books' => $books,
            'searchQuery' => $searchQuery ?? null,
            'searchResult' => $searchResult ?? null,
        ]);
    }
}