<?php

namespace Haru0\EloquentSqlDumper\Tests\Unit\Events;

use Haru0\EloquentSqlDumper\Events\DumpEvent;
use Illuminate\Database\Query\Builder;
use PHPUnit\Framework\TestCase;

/**
 * DumpEventTest class.
 *
 * @package Haru0\EloquentSqlDumper\Tests\Unit\Events
 * @author Michal Haracewiat <admin@haracewiat.pl>
 */
class DumpEventTest extends TestCase
{

    public function testConstructor()
    {
        $event = $this
            ->getMockBuilder(DumpEvent::class)
            ->setConstructorArgs([
                ($builder = $this->createMock(Builder::class))
            ])
            ->getMock();

        $reflection = new \ReflectionProperty(DumpEvent::class, 'builder');
        $reflection->setAccessible(true);

        $this->assertSame($builder, $reflection->getValue($event));
    }

    public function testGetBuilder()
    {
        $event = $this->getMockForAbstractClass(DumpEvent::class, [], '', $callOriginalConstructor = false);

        $reflection = new \ReflectionProperty(DumpEvent::class, 'builder');
        $reflection->setAccessible(true);
        $reflection->setValue($event, ($builder = $this->createMock(Builder::class)));

        /** @var DumpEvent $event */

        $this->assertSame($builder, $event->getBuilder($event));
    }

}
