<?php

namespace Lzpeng\TimeDuration;

use InvalidArgumentException;

/**
 * 表示一个纯时间
 * 
 * @author lzpeng <liuzhanpeng@gmail.com>
 */
class Time
{
    /**
     * 时
     *
     * @var integer
     */
    private int $hour;

    /**
     * 分
     *
     * @var integer
     */
    private int $minute;

    /**
     * 秒
     *
     * @var integer
     */
    private int $second;

    /**
     * 构造
     *
     * @param integer $hour 时
     * @param integer $minute 分
     * @param integer $second 秒
     */
    public function __construct(int $hour, int $minute = 0, int $second = 0)
    {
        if ($hour < 0 || $hour > 23) {
            throw new InvalidArgumentException('hour必须在0-23之间');
        }

        if ($minute < 0 || $minute > 59) {
            throw new InvalidArgumentException('minute必须在0-59之间');
        }

        if ($second < 0 || $second > 59) {
            throw new InvalidArgumentException('minute必须在0-59之间');
        }

        $this->hour = $hour;
        $this->minute = $minute;
        $this->second = $second;
    }

    /**
     * 通过格式化的时间创建时间对象
     *
     * @param string $formatTime 格式化时间; 如: 15:30 或 16:20:30
     * @return self
     */
    public static function createFrom(string $formatTime): self
    {
        if (preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9](:[0-5][0-9])?$/', $formatTime) !== 1) {
            throw new InvalidArgumentException('无效时间格式');
        }

        $segments = explode(':', $formatTime);
        $hour = intval($segments[0]);
        $minute = intval($segments[1]);
        $second = isset($segments[2]) ? intval($segments[2]) : 0;

        return new self($hour, $minute, $second);
    }

    /**
     * 返回时
     *
     * @return integer
     */
    public function hour(): int
    {
        return $this->hour;
    }

    /**
     * 返回分
     *
     * @return integer
     */
    public function minute(): int
    {
        return $this->minute;
    }

    /**
     * 返回秒
     *
     * @return integer
     */
    public function second(): int
    {
        return $this->second;
    }

    /**
     * 绝对秒数
     *
     * @return integer
     */
    public function absoluteSeconds(): int
    {
        return $this->hour() * 3600 + $this->minute() * 60 + $this->second();
    }

    /**
     * 返回格式化时间
     *
     * @param string $format 格式
     * @return string
     */
    public function format(string $format = 'H:i'): string
    {
        $format = str_replace('H', sprintf('%02d', $this->hour()), $format);
        $format = str_replace('i', sprintf('%02d', $this->minute()), $format);
        $format = str_replace('s', sprintf('%02d', $this->second()), $format);

        return $format;
    }

    /**
     * 判断是否同一时间
     *
     * @param Time $time
     * @return boolean
     */
    public function equals(Time $time): bool
    {
        return $this->absoluteSeconds() == $time->absoluteSeconds();
    }

    /**
     * 判断当前时间是否早于指定时间
     *
     * @param Time $time
     * @return boolean
     */
    public function earlierThan(Time $time): bool
    {
        return $this->absoluteSeconds() < $time->absoluteSeconds();
    }

    /**
     * 判断当前时间是否晚于指定时间
     *
     * @param Time $time
     * @return boolean
     */
    public function laterThan(Time $time): bool
    {
        return $this->absoluteSeconds() > $time->absoluteSeconds();
    }
}
