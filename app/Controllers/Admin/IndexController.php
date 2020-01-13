<?php

namespace App\Controllers\Admin;

use App\Models\Book;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class IndexController extends AdminAbstractController
{
    /**
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index()
    {
        $books = Book::all()->toArray();

        echo $this->twig->render('admin/index.twig', [
            'books' => $books,
        ]);
    }
}