Symfony Classroom Application
========================

Requirements
------------

  * PHP 7.2 or higher;
  * PDO-SQLite PHP extension enabled;

Installation
------------

Run this commands:

```bash
$ git clone git@github.com:chopko/symfony.git
$ cd my_project/
$ composer install
```
Database
-----
Set the database in .env files(.env.test for phpunit tests)

Run this commands:

```bash
$ cd my_project/
$ php bin/console doctrine:migrations:migrate
$ php bin/console doctrine:fixtures:load
```
Usage
-----

Run this command to run the built-in
web server and access the application in your browser at <http://localhost:8000>:

```bash
$ cd my_project/
$ php bin/console server:start
```

Tests
-----

Execute this command to run tests:

```bash
$ cd my_project/
$ ./bin/phpunit
