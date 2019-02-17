## Eloquent SQL dumper

This Laravel package introduces simple service for dumping SQL with binded values.

This repository originated from my [blog post](http://haracewiat.pl/2019/02/16/dump-eloquent-sql/).

## Features

This package registers a `dump` macro on `\Illuminate\Database\Query\Builder` which then can be used for logging and debugging.

## Usage

Dumper can be basically used anywhere once registered. 

Example `routes/web.php` file:

```php
use Illuminate\Database\Query\Builder;

Route::get('/', function () {
    $query = DB::query()
        ->from('users')
        ->where('active', true)
        ->where(function (Builder $builder) {
            $builder
                ->orWhere('email', 'like', '%gmail.com')
                ->orWhere('email', 'like', '%example.com');
        })
        ->orderByDesc('id')
        ->limit(10);

    dd($query->dump());
});
```

`Tinker` version, for REPL lovers:

```bash
Psy Shell v0.9.9 (PHP 7.3.2-3+ubuntu18.04.1+deb.sury.org+1 — cli) by Justin Hileman
>>> DB::query() \
...     ->from('users') \
...     ->where('active', true) \
...     ->where(function ($builder) { \
...     $builder \
...         ->orWhere('email', 'like', '%gmail.com') \
...         ->orWhere('email', 'like', '%example.com'); \
...     }) \
...     ->orderByDesc('id') \
...     ->limit(10) \
...     ->dump()
=> "select * from `users` where `active` = 1 and (`email` like '%gmail.com' or `email` like '%example.com') order by `id` desc limit 10"
```

## Installation

```bash
composer require --dev haru0/eloquent-sql-dumper
```

This package supports **package discovery** and can be used straight away after adding to your dependencies list. 

If your project disables self discovery feature it is necessary to manually register service provider. For example, adding this line below, inside `config/app.php` file.

```php
/*
 * Package Service Providers...
 */
Haru0\EloquentSqlDumper\ServiceProvider::class,
```

Although, you will be fine, I strongly discourage you from using this library on production for logging purposes. 
I believe it's not the proper way to do this, and you should seek for dedicated logging solution.

No configuration options available.

## Contribute

Any contribution is welcome. Fork this repository and create a pull request. Please remember to provide description.

## License

MIT
