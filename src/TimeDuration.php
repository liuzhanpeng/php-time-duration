<?php

namespace Lzpeng\TimeDuration;

use InvalidArgumentException;

/**
 * 时间段
 * 
 * @author lzpeng <liuzhanpeng@gmail.com>
 */
class TimeDuration
{
    /**
     * 开始时间
     *
     * @var Time
     */
    private Time $startTime;

    /**
     * 结束时间
     *
     * @var Time
     */
    private Time $endTime;

    /**
     * 构造
     *
     * @param Time $startTime
     * @param Time $endTime
     */
    public function __construct(Time $startTime, Time $endTime)
    {
        if ($endTime->earlierThan($startTime) || $endTime->equals($startTime)) {
            throw new InvalidArgumentException('结束时间必须晚于开始时间');
        }

        $this->startTime = $startTime;
        $this->endTime = $endTime;
    }

    /**
     * 返回开始时间
     *
     * @return Time
     */
    public function startTime(): Time
    {
        return $this->startTime;
    }

    /**
     * 返回结束时间
     *
     * @return Time
     */
    public function endTime(): Time
    {
        return $this->endTime;
    }

    /**
     * 判断当前时间段是否与指定时间段冲突
     *
     * @param TimeDuration $timeDuration
     * @return boolean
     */
    public function isConflictWith(TimeDuration $timeDuration): bool
    {
        if (
            $timeDuration->startTime()->laterThan($this->startTime())
            && $timeDuration->startTime()->earlierThan($this->endTime())
        ) {
            // 目标开始时间在 当前时间内
            // 当前时间:  |-----|
            // 目标时间:      |-----|
            return true;
        } elseif (
            $timeDuration->endTime()->earlierThan($this->startTime())
            && $timeDuration->endTime()->laterThan($this->endTime())
        ) {
            // 目标结束时间在 当前时间内
            // 当前时间:    |-----|
            // 目标时间: |-----|
            return true;
        } elseif (
            $timeDuration->startTime()->earlierThan($this->startTime())
            && $timeDuration->endTime()->laterThan($this->endTime())
        ) {
            // 目标结束时间在 当前时间内
            // 当前时间:    |-----|
            // 目标时间: |------------|
            return true;
        }

        return false;
    }
}
