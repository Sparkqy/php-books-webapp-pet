<?php

return [
    // Auth
    '@^/login$@' => ['GET', \App\Controllers\Auth\LoginController::class, 'index'],

    '@^/logout$@' => ['GET', \App\Controllers\Auth\LogoutController::class, 'logout'],

    '@^/auth/login$@' => ['POST', \App\Controllers\Auth\LoginController::class, 'login'],

    // Pages
    '@^/$@' => ['GET', App\Controllers\Books\IndexController::class, 'index'],

    '@^/books/pagination$@' => ['GET', App\Controllers\Books\PaginationController::class, 'index'],

    '@^/books/pagination/set-limit$@' => ['POST', App\Controllers\Books\PaginationController::class, 'setPageLimit'],

    '@^/books/search$@' => ['GET', App\Controllers\Books\SearchController::class, 'index'],

    '@^/books/filters$@' => ['GET', App\Controllers\Books\FiltersController::class, 'index'],

    '@^/books/filters/filter-by-tags$@' => ['POST', App\Controllers\Books\FiltersController::class, 'filterByTags'],

    '@^/books/filters/filter-by-price$@' => ['POST', App\Controllers\Books\FiltersController::class, 'sortByPrice'],

    '@^/books/filters/filter-by-name$@' => ['POST', App\Controllers\Books\FiltersController::class, 'sortByName'],

    // Admin
    '@^/admin$@' => ['GET', \App\Controllers\Admin\IndexController::class, 'index'],

    '@^/admin/books/store$@' => ['POST', \App\Controllers\Admin\BooksController::class, 'store'],

    '@^/admin/books/(\d+)/edit$@' => ['GET', \App\Controllers\Admin\BooksController::class, 'edit'],

    '@^/admin/books/(\d+)/update$@' => ['POST', \App\Controllers\Admin\BooksController::class, 'update'],

    '@^/admin/books/(\d+)/delete$@' => ['POST', \App\Controllers\Admin\BooksController::class, 'destroy'],
];
