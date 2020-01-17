<?php

namespace App\Controllers\Admin;

use App\Models\Book;
use App\Models\Tag;
use Exception;
use Src\Helpers\Router;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class BooksController extends AdminAbstractController
{
    /**
     * @var array
     */
    private $validationRules = [
        'isbn' => 'numeric',
        'name' => 'required',
        'price' => 'numeric',
        'url' => 'required',
        'poster' => 'required',
    ];

    public function store(): void
    {
        if (isset($_POST['submit_book_add'])) {
            $validator = $this->validator->validate($_POST, $this->validationRules);

            if ($validator->hasErrors()) {
                Router::redirectWithFlash('error', [
                    'message' => $this->validator->echoErrors(),
                    'class' => 'alert-danger',
                ], '/admin');
            }

            $validData = $validator->get();
            $book = Book::create($validData);
            $book->tags()->attach($validData['tags']);

            Router::redirectWithFlash('success', [
                'message' => 'Book was successfully added to database',
                'class' => 'alert-success',
            ], '/admin');
        }
    }

    /**
     * @param int $id
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function edit(int $id): void
    {
        $book = Book::findOrFail($id);
        $tags = Tag::all();

        echo $this->twig->render('admin/books/edit.twig', [
            'book' => $book,
            'tags' => $tags,
        ]);
    }

    /**
     * @param int $id
     */
    public function update(int $id): void
    {
        if (isset($_POST['submit_book_edit'])) {
            $book = Book::findOrFail($id);

            $validator = $this->validator->validate($_POST, $this->validationRules);

            if ($validator->hasErrors()) {
                Router::redirectWithFlash('error', [
                    'message' => $this->validator->echoErrors(),
                    'class' => 'alert-danger',
                ], '/admin');
            }

            $validData = $validator->get();
            $book->update($validData);
            $book->tags()->sync($validData['tags']);

            Router::redirectWithFlash('success', [
                'message' => 'Book was successfully edited',
                'class' => 'alert-success',
            ], '/admin');
        }
    }

    /**
     * @param int $id
     * @throws Exception
     */
    public function destroy(int $id): void
    {
        /** @var Book $book */
        $book = Book::findOrFail($id);
        $book->delete();

        Router::redirectWithFlash('success', [
            'message' => 'Book was successfully deleted',
            'class' => 'alert-success',
        ], '/admin');
    }
}