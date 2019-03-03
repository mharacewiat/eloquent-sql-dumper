<?php

namespace Haru0\EloquentSqlDumper;

use Haru0\EloquentSqlDumper\Contracts\DumperContract;
use Haru0\EloquentSqlDumper\Services\DumperService;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\Support\Str;

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

        $this->publishes(
            [$this->getConfigPath() => config_path('eloquent-sql-dumper.php')],
            'config'
        );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom($this->getConfigPath(), 'eloquent-sql-dumper');

        $this->app->singleton(DumperContract::class, DumperService::class);

        Builder::macro($this->getMacroName(), function () {
            /** @var Builder $this */
            return app(DumperContract::class)->dump($this);
        });
    }


    /**
     * @return string
     */
    protected function getConfigPath(): string
    {
        return __DIR__ . '/../config/ide-helper.php';
    }

    /**
     * @return string
     */
    protected function getMacroName(): string
    {
        return Str::camel(config('eloquent-sql-dumper.macro'));
    }

}
