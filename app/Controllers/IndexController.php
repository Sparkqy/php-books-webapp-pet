<?php

namespace App\Controllers;

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
    public function index(): void
    {
        $books = Book::with('tags')->get();

        echo $this->twig->render('books/index.twig', [
            'books' => $books,
        ]);
    }
}