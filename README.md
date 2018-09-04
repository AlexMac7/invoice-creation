# Invoice Creation

## Setup

* Clone the repository

* Install dependencies with composer and npm or yarn:

```
$ composer install && yarn install
```

* Create a new database named `invoice-creation`

* Create a .env and copy the provided .env.example file to it, using your own `DB_USERNAME` and `DB_PASSWORD` if required.

* Run `php artisan key:generate`

* Run `phpunit`, all tests should pass

* Run `php artisan migrate:fresh --seed` to create a customer and three products

* Start a local web server with `php artisan serve --port=8001` or [Valet][2]

* Enjoy!

This application uses [Laravel][1].

[1]:https://laravel.com/
[2]:https://laravel.com/docs/5.6/valet
