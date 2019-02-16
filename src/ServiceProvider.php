<?php

namespace Haru0\EloquentSqlDumper;

use Haru0\EloquentSqlDumper\Services\Dumper;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

/**
 * ServiceProvider class.
 *
 * @package Haru0\EloquentSqlDumper
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
class ServiceProvider extends BaseServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @param Dumper $dumper
     * @return void
     */
    public function boot(Dumper $dumper)
    {
        Builder::macro('dump', function () use ($dumper) {
            /** @var Builder $this */
            return $dumper->dump($this);
        });
    }

}
