# php-books-db

Main tasks: Сделать версию книжного магазина №2 в которой все книги будут храниться в БД
Реализовать все фильтры из предыдущей задачи
Сделать пользователя Admin которому будут доступны возможности: добавлять/редактировать/удалять книги

Bonus tasks: 
Использовать Eloquent для работы с БД
Использовать Eloquent или любой другой пакет из Composer для миграции БД
Использовать Faker для того, чтобы засидить БД фейковыми данными



# How to run the application:
1. `git clone https://git.epam.com/illia_koliadenko/php-books-db`
2. `docker-compose up -d --build`
3. `docker-compose exec webserver bash`
4. `composer install`
5. `vendor/bin/phinx migrate` (if migration fails because of missing database: 1. `docker-compose exec db bash` 2. create database 'php-books')
6. `vendor/bin/phinx seed:run`
7. to log in into the dashboard use email and password ('admin' for both users) from two randomly generated users in users table. If you want to access 'admin dashboard' use credentials of user with 'is_admin' set to 1  

