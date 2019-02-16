<?php

namespace Haru0\EloquentSqlDumper\Contracts;

use Illuminate\Database\Query\Builder;

/**
 * Dumper interface.
 *
 * @package Haru0\EloquentSqlDumper\Services
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
interface Dumper
{

    /**
     * @param Builder $builder
     * @return string
     */
    public function dump(Builder $builder): string;

}
