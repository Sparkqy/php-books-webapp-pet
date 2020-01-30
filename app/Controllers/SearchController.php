<?php

namespace App\Controllers;

use App\Models\Book;
use Exception;
use Src\Core\DI\DI;
use src\Exceptions\DIContainerException;
use Src\Helpers\Router;
use stdClass;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SearchController extends AbstractController
{
    /**
     * @var stdClass
     */
    private stdClass $bookModel;

    /**
     * @var array
     */
    private array $validationRules = ['search_query' => 'required'];

    /**
     * SearchController constructor.
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
            [$searchQuery, $searchResult] = $this->bookModel->repository->search($validData['search_query'], 'name');
        }

        echo $this->twig->render('books/search/index.twig', [
            'books' => $books,
            'searchQuery' => $searchQuery ?? null,
            'searchResult' => $searchResult ?? null,
        ]);
    }
}