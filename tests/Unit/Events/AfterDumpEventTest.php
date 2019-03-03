<?php

namespace Haru0\EloquentSqlDumper\Tests\Unit\Events;

use Haru0\EloquentSqlDumper\Events\AfterDumpEvent;
use Illuminate\Database\Query\Builder;
use PHPUnit\Framework\TestCase;

/**
 * AfterDumpEventTest class.
 *
 * @package Haru0\EloquentSqlDumper\Tests\Unit\Events
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
class AfterDumpEventTest extends TestCase
{

    public function testConstructor()
    {
        $sql   = 'foo';
        $event = new AfterDumpEvent($sql, $this->createMock(Builder::class));

        $reflection = new \ReflectionProperty(AfterDumpEvent::class, 'sql');
        $reflection->setAccessible(true);

        $this->assertSame($sql, $reflection->getValue($event));
    }

    public function testSetSql()
    {
        $event = $this->createPartialMock(AfterDumpEvent::class, []);

        $reflection = new \ReflectionProperty(AfterDumpEvent::class, 'sql');
        $reflection->setAccessible(true);
        $reflection->setValue($event, 'foo');

        /** @var AfterDumpEvent $event */

        $event->setSql($sql = 'bar');
        $this->assertSame($sql, $reflection->getValue($event));
    }

}
