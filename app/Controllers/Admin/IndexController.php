<?php

namespace App\Controllers\Admin;

use App\Models\Book;
use App\Models\Tag;
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
    public function index(): void
    {
        $books = Book::all();
        $tags = Tag::all();

        echo $this->twig->render('admin/index.twig', [
            'books' => $books,
            'tags' => $tags,
        ]);
    }
}