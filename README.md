## Eloquent SQL dumper
This is Laravel package introducing simple service for dumping complete SQL queries.

## Features
This package boots QueryBuilder `dump` macro for logging and debugging purposes.

## Usage

Example `routes/web.php` file

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

`Tinker` version

    Psy Shell v0.9.9 (PHP 7.3.2-3+ubuntu18.04.1+deb.sury.org+1 — cli) by Justin Hileman
    ```bash
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

This package supports package discovery and can be used straight away. If your project disables self discovery feature it is necessary to manually register service provider.

For example, adding this line below, inside `config/app.php` file.

    ```php
    /*
     * Package Service Providers...
     */
    Haru0\EloquentSqlDumper\ServiceProvider::class,
    ```
