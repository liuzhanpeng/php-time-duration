<?php

namespace Lzpeng\Test;

use Lzpeng\TimeDuration\Time;
use Lzpeng\TimeDuration\TimeDuration;
use PHPUnit\Framework\TestCase;

class TestTimeDuration extends TestCase
{
    private function createDuration(string $startTime, string $endTime)
    {
        $startTime = Time::createFrom($startTime);
        $endTime = Time::createFrom($endTime);

        return new TimeDuration($startTime, $endTime);
    }

    public function testConstruct()
    {
        $duration = $this->createDuration('15:30', '17:00');
        $this->assertEquals(Time::createFrom('15:30'), $duration->startTime());
        $this->assertEquals(Time::createFrom('17:00'), $duration->endTime());
    }

    public function testConflict()
    {
        $duration1 = $this->createDuration('15:30', '17:00');
        $duration2 = $this->createDuration('16:59', '18:00');
        $duration3 = $this->createDuration('17:00', '18:00');
        $duration4 = $this->createDuration('17:01', '18:00');
        $duration5 = $this->createDuration('14:00', '15:31');
        $duration6 = $this->createDuration('14:00', '15:30');

        $this->assertTrue($duration1->isConflictWith($duration2));
        $this->assertFalse($duration1->isConflictWith($duration3));
        $this->assertFalse($duration1->isConflictWith($duration4));
        $this->assertTrue($duration1->isConflictWith($duration5));
        $this->assertTrue($duration1->isConflictWith($duration6));
    }
}
