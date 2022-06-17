<?php

namespace Lzpeng\Test;

use InvalidArgumentException;
use Lzpeng\TimeDuration\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    public function testConstruct()
    {
        $time = new Time(16, 30, 20);
        $this->assertEquals(16, $time->hour());
        $this->assertEquals(30, $time->minute());
        $this->assertEquals(20, $time->second());
        // 16 * 3600 + 30 * 60 + 20
        $this->assertEquals(59420, $time->absoluteSeconds());
        $this->assertEquals('16:30:20', $time->format('H:i:s'));
        $this->assertEquals('16:30', $time->format('H:i'));

        $time2 = new Time(17, 10);
        $this->assertEquals(17, $time2->hour());
        $this->assertEquals(10, $time2->minute());
        $this->assertEquals(0, $time2->second());
        $this->assertEquals(61800, $time2->absoluteSeconds());
        $this->assertEquals('17:10:00', $time2->format('H:i:s'));
        $this->assertEquals('17:10', $time2->format('H:i'));

        $time3 = new Time(10);
        $this->assertEquals(10, $time3->hour());
        $this->assertEquals(0, $time3->minute());
        $this->assertEquals(0, $time3->second());
        $this->assertEquals(36000, $time3->absoluteSeconds());
        $this->assertEquals('10:00:00', $time3->format('H:i:s'));
        $this->assertEquals('10:00', $time3->format('H:i'));

        $time4 = new Time(0, 8, 8);
        $this->assertEquals(0, $time4->hour());
        $this->assertEquals(8, $time4->minute());
        $this->assertEquals(8, $time4->second());
        $this->assertEquals(488, $time4->absoluteSeconds());
        $this->assertEquals('00:08:08', $time4->format('H:i:s'));
        $this->assertEquals('00:08', $time4->format('H:i'));
    }

    public function testFormFormat()
    {
        $time = Time::createFrom('09:02:08');

        $this->assertEquals(9, $time->hour());
        $this->assertEquals(2, $time->minute());
        $this->assertEquals(8, $time->second());
        $this->assertEquals(32528, $time->absoluteSeconds());

        $time2 = Time::createFrom('23:00');
        $this->assertEquals(23, $time2->hour());
        $this->assertEquals(0, $time2->minute());
        $this->assertEquals(0, $time2->second());
        $this->assertEquals(82800, $time2->absoluteSeconds());

        $time3 = Time::createFrom('00:08:08');
        $this->assertEquals(0, $time3->hour());
        $this->assertEquals(8, $time3->minute());
        $this->assertEquals(8, $time3->second());
        $this->assertEquals(488, $time3->absoluteSeconds());
    }

    public function testCompare()
    {
        $time = Time::createFrom('15:30');
        $time2 = Time::createFrom('15:30');
        $time3 = Time::createFrom('15:29');
        $time4 = Time::createFrom('15:31');
        $time5 = Time::createFrom('08:00');
        $time6 = Time::createFrom('20:00');

        $this->assertTrue($time->equals($time2));
        $this->assertTrue($time->laterThan($time3));
        $this->assertTrue($time->earlierThan($time4));
        $this->assertTrue($time->laterThan($time5));
        $this->assertTrue($time->earlierThan($time6));
    }

    public function testInvalidConstruct()
    {
        $this->expectException(InvalidArgumentException::class);
        $time = new Time(-1, 0, 10);
    }

    public function testInvalidConstruct2()
    {
        $this->expectException(InvalidArgumentException::class);
        $time = new Time(24, 10, 10);
    }

    public function testInvalidConstruct3()
    {
        $this->expectException(InvalidArgumentException::class);
        $time = new Time(10, -1, 10);
    }

    public function testInvalidConstruct4()
    {
        $this->expectException(InvalidArgumentException::class);
        $time = new Time(10, 60, 10);
    }

    public function testInvalidConstruct5()
    {
        $this->expectException(InvalidArgumentException::class);
        Time::createFrom('xxx');
    }

    public function testInvalidConstruct6()
    {
        $this->expectException(InvalidArgumentException::class);
        Time::createFrom('10');
    }
}
