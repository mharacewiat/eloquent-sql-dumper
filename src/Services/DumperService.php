<?php

namespace Haru0\EloquentSqlDumper\Services;

use Haru0\EloquentSqlDumper\Contracts\DumperContract;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

/**
 * DumperService class.
 *
 * @package Haru0\EloquentSqlDumper\Services
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
class DumperService implements DumperContract
{

    /**
     * @param Builder $builder
     * @return string
     */
    public function dump(Builder $builder): string
    {
        $sql = $builder->toSql();

        foreach ($this->getBindings($builder) as $binding) {
            $sql = Str::replaceFirst('?', (is_numeric($binding) ? $binding : sprintf('"%s"', $binding)), $sql);
        }

        return $sql;
    }

    /**
     * @param Builder $builder
     * @return iterable
     */
    protected function getBindings(Builder $builder): iterable
    {
        return $builder->getConnection()->prepareBindings($builder->getBindings());
    }

}
