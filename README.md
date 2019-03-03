[![CircleCI](https://circleci.com/gh/Haru0/eloquent-sql-dumper.svg?style=svg)](https://circleci.com/gh/Haru0/eloquent-sql-dumper) 
[![SymfonyInsight](https://insight.symfony.com/projects/435fee6e-6c83-4fc0-a49e-5a6b6ffef2a6/mini.svg)](https://insight.symfony.com/projects/435fee6e-6c83-4fc0-a49e-5a6b6ffef2a6)

## Eloquent SQL dumper

This **Laravel package** introduces simple service for **dumping** SQL with binded values.

This repository originated from [my personal blog](http://haracewiat.pl/2019/02/16/dump-eloquent-sql/), and aims to briefly explain advantages of Laravel's `Illuminate\Support\Traits\Macroable`.

## Features

Delivered `Haru0\EloquentSqlDumper\ServiceProvider` registers a `dump` macro on `Illuminate\Database\Query\Builder` which then could be then used for **logging** and **debugging**.

Although, you will be fine, I strongly discourage you from using this library on production for logging purposes. I believe it's not the proper way for this, and you should seek for dedicated logging solution.

## Installation

```bash
composer require --dev haru0/eloquent-sql-dumper
```

This package supports **package-discovery** and can be used straight away after adding to the Composer's dependencies.

If your project disables package-discovery feature, it is necessary to manually register `Haru0\EloquentSqlDumper\ServiceProvider`. This can be done by adding this line below, inside `config/app.php` file.

```php
/*
 * Package Service Providers...
 */
Haru0\EloquentSqlDumper\ServiceProvider::class,
```

No configuration options available.

## Usage

`Haru0\EloquentSqlDumper\Services\DumperService`, once registered, can be basically used anywhere. It is also easily **overrideable** and **extensible**.

Example `routes/web.php` file:

```php
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

`Tinker` version, for **REPL** lovers:

```bash
Psy Shell v0.9.9 (PHP 7.3.2-3+ubuntu18.04.1+deb.sury.org+1 — cli) by Justin Hileman
>>> DB::query() \
...     ->from('users') \
...     ->where('active', true) \
...     ->where(function ($builder) { \
...         $builder \
...             ->orWhere('email', 'like', '%gmail.com') \
...             ->orWhere('email', 'like', '%example.com'); \
...     }) \
...     ->orderByDesc('id') \
...     ->limit(10) \
...     ->dump()
=> "select * from `users` where `active` = 1 and (`email` like '%gmail.com' or `email` like '%example.com') order by `id` desc limit 10"
```

## Overriding and extending 

If you need to adjust or override `Haru0\EloquentSqlDumper\Services\DumperService` functionality, you're welcome to either **bind implementation to the contract**, or **register listener** to the two events dispatched by the service. 

Depending on your needs, one of the ways of customizing `dump` macro, is to write your own `DumperService` and bind it to the `Haru0\EloquentSqlDumper\Contracts\DumperContract`.

```php
use App\Services\MyDumper;
use Haru0\EloquentSqlDumper\Contracts\DumperContract;

$this->app->bind(DumperContract::class, MyDumper::class);
```

Other way of customizing `dump` macro is to register a [listener](https://laravel.com/docs/5.7/events#defining-listeners) or [subscriber](https://laravel.com/docs/5.7/events#event-subscribers) to the `Haru0\EloquentSqlDumper\Events\AfterDumpEvent` and `Haru0\EloquentSqlDumper\Events\BeforeDumpEvent` events. 

Finally, you can modify macro name (in case it collides with existing one). To do so, adjust configuration option or put `ELOQUENT_SQL_DUMPER_MACRO` environment variable into your `.env` file.

```dotenv
ELOQUENT_SQL_DUMPER_MACRO=foo_bar_baz
```

and then, use it the same way `dump` was shown in the [Usage](#Usage) chapter.

> Macro name is **always** casted to [Camel case](https://en.wikipedia.org/wiki/Camel_case). In this example above, your macro will be executed by `$query->fooBarBaz`.

## Contribute

Any contribution is welcome. Fork this repository and create a pull request. Please remember to provide brief description.

[Here you can find all contributors](https://github.com/Haru0/eloquent-sql-dumper/graphs/contributors).

## License

MIT
