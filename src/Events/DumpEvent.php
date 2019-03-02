<?php

namespace Haru0\EloquentSqlDumper\Events;

use Illuminate\Database\Query\Builder;

/**
 * DumpEvent abstract class.
 *
 * @package Haru0\EloquentSqlDumper\Events
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
abstract class DumpEvent
{

    /**
     * @var Builder
     */
    protected $builder;


    /**
     * DumpEvent constructor.
     *
     * @param Builder $builder
     */
    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }


    /**
     * @return Builder
     */
    public function getBuilder(): Builder
    {
        return $this->builder;
    }

}
