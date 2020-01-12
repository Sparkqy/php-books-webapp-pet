<?php

namespace App\Controllers\Books;

use App\Controllers\AbstractController;
use App\Models\Book;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class IndexController extends AbstractController
{
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index()
    {
        $books = Book::all();

        echo $this->twig->render('books/index.twig', [
            'books' => $books,
        ]);
    }
}