<?php

namespace App\Controllers\Books;

use App\Controllers\AbstractController;
use App\Models\Book;
use Src\Exceptions\InappropriateTypeException;
use Src\Helpers\Cookie;
use Src\Helpers\Router;
use Src\Services\Pagination\Pagination;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class PaginationController extends AbstractController
{
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws InappropriateTypeException
     */
    public function index(): void
    {
        $limit = $_COOKIE['books_page_limit'] ?? 10;
        $pagination = new Pagination(Book::with('tags')->get()->toArray(), '/books/pagination');
        $books = $pagination->paginate($limit);

        echo $this->twig->render('books/pagination/index.twig', [
            'books' => $books,
            'pagination' => $pagination,
        ]);
    }

    public function setPageLimit(): void
    {
        if (isset($_POST['submit_page_limit'])) {
            $limit = $_POST['page_limit'] ?? null;

            if (empty($limit) || !is_numeric($limit) || $limit < 0) {
                Router::redirectWithFlash('error', [
                    'message' => 'Page limit value must be numeric and greater than zero',
                    'class' => 'alert-danger',
                ], '/books/pagination');
            }

            Cookie::set('books_page_limit', $limit);
            Router::redirect('/books/pagination');
        }
    }
}