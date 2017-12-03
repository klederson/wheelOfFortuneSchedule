<?php

namespace WheelOfFortuneBundle\Business\Model;

use ApplicationBundle\Communication\DataTransferObjects\DevelopersDto;

class WheelOfFortuneModel
{
    const ERROR_MIN_DAYS = "error.min.days.not.achieved";

    const SLOTS_MULTIPLIER = 2;
    const VALID_DAYS_PER_WEEK = 5;
    const TOTAL_CYCLE_TIME = 10;
    const MIN_CYCLE = 2;

    private static $slots;

    /**
     * @param int $days
     * @param array $developers
     *
     * @return mixed
     * @throws \Exception
     */
    public static function randomiseShifts(int $days, array $developers)
    {
        if($days < 1) {
            throw new \Exception(self::ERROR_MIN_DAYS);
        }

        self::generateEmptySlots($days);

        foreach(self::$slots as $dayIndex => $dayAssignments) {
            while (count(self::$slots[$dayIndex]) < self::SLOTS_MULTIPLIER) {
                $developer = self::getRandomDeveloperForTheShift($developers, $dayIndex);
                self::$slots[$dayIndex][] = $developer->getUuid();
            }
        }

        return self::$slots;
    }

    /**
     * @param string $uuid
     *
     * @return array
     */
    public static function getDeveloperShifts($uuid)
    {
        $developerShifts = [];
        $slots = self::getSlots();

        foreach($slots as $dayIndex => $dayAssignments) {
            if(in_array($uuid, $dayAssignments)) {
                $developerShifts[] = $dayIndex;
            }
        }

        if(!asort($developerShifts)) {
            return false;
        }

        return $developerShifts;
    }

    /**
     * @param $uuid
     *
     * @return int
     */
    public static function getLatestDeveloperShift($uuid)
    {
        $developerShifts = self::getDeveloperShifts($uuid);

        return array_pop($developerShifts);
    }


    /**
     * @param array $developers
     * @param int $dayIndex
     *
     * @return mixed|DevelopersDto
     */
    public static function getRandomDeveloperForTheShift(array $developers, int $dayIndex)
    {
        $choice = self::spinWheel($developers);

        if(!self::isAllowed($choice->getUuid(), $dayIndex)) {
            $choice = self::getRandomDeveloperForTheShift($developers, $dayIndex);
        }

        return $choice;
    }

    /**
     * @param string $uuid
     * @param int $dayIndex
     *
     * @return bool
     */
    private static function isAllowed(string $uuid, int $dayIndex)
    {
        $previousDay = $dayIndex > 0 ? $dayIndex - 1 : $dayIndex;

        if(in_array($uuid, self::$slots[$dayIndex]) || in_array($uuid, self::$slots[$previousDay])) {
            return false;
        }

        $totalRange = count(self::$slots) / self::SLOTS_MULTIPLIER;
        $blocks = ceil($totalRange / self::TOTAL_CYCLE_TIME);
        $blockDayLimit = $totalRange / $blocks;
        $currentBlock = ceil($dayIndex / self::TOTAL_CYCLE_TIME);

        $developerShifts = self::getDeveloperShifts($uuid);

        $shiftCounter = 0;
        foreach($developerShifts as $shiftDayIndex) {
            $shiftBlock = ceil($shiftDayIndex / $blockDayLimit);
            if($shiftBlock === $currentBlock) {
                $shiftCounter++;
            }
        }

        if($shiftCounter >= self::MIN_CYCLE) {
            return false;
        }

        return true;
    }

    /**
     * @param array $items
     *
     * @return mixed
     */
    public static function spinWheel(array $items)
    {
        return $items[array_rand($items)];
    }

    /**
     * @param int $amount
     *
     * @return array
     */
    private static function generateEmptySlots(int $amount)
    {
        self::$slots = [];

        for($i = 0; $i < $amount; $i++) {
            self::$slots[$i] = [];
        }

        return self::$slots;
    }

    /**
     * @return array
     */
    public static function getSlots()
    {
        return self::$slots;
    }
}
