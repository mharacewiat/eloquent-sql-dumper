<?php

namespace Haru0\EloquentSqlDumper\Tests\Unit\Services;

use Haru0\EloquentSqlDumper\Services\DumperService;
use Illuminate\Database\Query\Builder;
use PHPUnit\Framework\TestCase;

/**
 * DumperServiceTest class.
 *
 * @package Haru0\EloquentSqlDumper\Tests\Unit\Services
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
class DumperServiceTest extends TestCase
{

    public function testDump()
    {
        $dumper  = $this->createPartialMock(DumperService::class, [
            'fireAfterEvent',
            'fireBeforeEvent',
            'bindValues',
        ]);
        $builder = $this->createMock(Builder::class);


        $dumper
            ->expects($this->once())
            ->method('fireAfterEvent')
            ->with(($sql = 'foo'), $builder);

        $dumper
            ->expects($this->once())
            ->method('fireBeforeEvent')
            ->with($builder);

        $dumper
            ->expects($this->once())
            ->method('bindValues')
            ->with($builder)
            ->willReturn($sql);


        /**
         * @var DumperService $dumper
         * @var Builder $builder
         */

        $this->assertSame($sql, $dumper->dump($builder));
    }

    public function testBindValues()
    {
        $dumper  = $this->createPartialMock(DumperService::class, [
            'getBindings',
        ]);
        $builder = $this->createPartialMock(Builder::class, [
            'toSql',
        ]);


        $dumper
            ->expects($this->once())
            ->method('getBindings')
            ->willReturn([
                'qux',
                'quux',
            ]);

        $builder
            ->expects($this->once())
            ->method('toSql')
            ->willReturn('foo ? bar ? baz');


        $reflection = new \ReflectionMethod(DumperService::class, 'bindValues');
        $reflection->setAccessible(true);


        $this->assertSame('foo "qux" bar "quux" baz', $reflection->invoke($dumper, $builder));
    }

}
