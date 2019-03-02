<?php

namespace Haru0\EloquentSqlDumper\Events;

use Illuminate\Database\Query\Builder;

/**
 * AfterDumpEvent class.
 *
 * @package Haru0\EloquentSqlDumper\Events
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
class AfterDumpEvent extends DumpEvent
{

    /**
     * @var string
     */
    protected $sql;


    /**
     * AfterDumpEvent constructor.
     *
     * @param string $sql
     * @param Builder $builder
     */
    public function __construct(string & $sql, Builder $builder)
    {
        parent::__construct($builder);

        $this->sql = $sql;
    }


    /**
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * @param string $sql
     */
    public function setSql(string $sql): void
    {
        $this->sql = $sql;
    }

}
