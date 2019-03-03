<?php

namespace Haru0\EloquentSqlDumper;

use Haru0\EloquentSqlDumper\Contracts\DumperContract;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * ServiceProvider class.
 *
 * @codeCoverageIgnore
 *
 * @package Haru0\EloquentSqlDumper
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
class ServiceProvider extends BaseServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (false === $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__ . '/../config/eloquent-sql-dumper.php' => config_path('eloquent-sql-dumper.php'),
        ], 'config');
    }

    /**
     * Register the application services.
     *
     * @param DumperContract $dumper
     * @return void
     */
    public function register(DumperContract $dumper)
    {
        Builder::macro(config('eloquent-sql-dump.macro'), function () use ($dumper) {
            /** @var Builder $this */
            return $dumper->dump($this);
        });
    }

}
