<?php

namespace Haru0\EloquentSqlDumper\Services;

use Haru0\EloquentSqlDumper\Contracts\Dumper as DumperContract;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

/**
 * Dumper class.
 *
 * @package Haru0\EloquentSqlDumper\Services
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
class Dumper implements DumperContract
{

    /**
     * @param Builder $builder
     * @return string
     */
    public function dump(Builder $builder): string
    {
        $sql = $builder->toSql();

        foreach ($builder->getBindings() as $binding) {
            $sql = Str::replaceFirst('?', (is_numeric($binding) ? $binding : sprintf('"%s"', $binding)), $sql);
        }

        return $sql;
    }

}
