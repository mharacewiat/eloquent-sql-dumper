<?php

namespace Haru0\EloquentSqlDumper\Contracts;

use Illuminate\Database\Query\Builder;

/**
 * DumperContract interface.
 *
 * @package Haru0\EloquentSqlDumper\Services
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
interface DumperContract
{

    /**
     * @param Builder $builder
     * @return string
     */
    public function dump(Builder $builder): string;

}
