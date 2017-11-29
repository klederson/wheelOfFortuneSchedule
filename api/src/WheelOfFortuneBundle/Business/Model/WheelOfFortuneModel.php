<?php

namespace WheelOfFortuneBundle\Business\Model;

use ApplicationBundle\Communication\DataTransferObjects\DevelopersDto;

class WheelOfFortuneModel
{
    const ERROR_MIN_DAYS = "error.min.days.not.achieved";

    const SLOTS_MULTIPLIER = 2;
    const MAX_INTERVAL_IN_WEEKS = 2;
    const VALID_DAYS_PER_WEEK = 5;

    private static $slots;

    public static function getDevelopersSchedule(int $days, array $developers)
    {
        if($days < 1) {
            throw new \Exception(self::ERROR_MIN_DAYS);
        }

        $response = [
            "days" => []
        ];

        self::resetSlots($days);

        foreach(self::$slots as $dayIndex => $dayAssignments) {
            while (count(self::$slots[$dayIndex]) < self::SLOTS_MULTIPLIER) {
                $developer = self::getRightChoice($developers, $dayIndex);
                self::$slots[$dayIndex][] = $developer->getUuid();
                $dev = [
                    "uuid" => $developer->getUuid(),
                    "fullName" => sprintf("%s %s", $developer->getFirstName(), $developer->getLastName() )
                ];

                $date = new \DateTime();
                $dateModifier = sprintf("+%s days", $dayIndex);
                $date->modify($dateModifier);

                $response["days"][$date->format("Y-m-d")][] = $dev;
            }
        }

        return $response;
    }

    public static function getSlots() {
        return self::$slots;
    }

    /**
     * @param array $developers
     * @param int $dayIndex
     *
     * @return mixed|DevelopersDto
     */
    public static function getRightChoice(array $developers, int $dayIndex) {
        $choice = self::spinWheel($developers);

        if(!self::isAllowed($choice->getUuid(), $dayIndex)) {
            $choice = self::getRightChoice($developers, $dayIndex);
        }

        return $choice;
    }

    private static function isAllowed(string $uuid, int $dayIndex) {
        $previousDay = $dayIndex > 0 ? $dayIndex - 1 : $dayIndex;

        if(in_array($uuid, self::$slots[$dayIndex])) {
            return false;
        }

        if(in_array($uuid, self::$slots[$previousDay])) {
            return false;
        }

        return true;
    }

    public static function spinWheel(array $items) {
        return $items[array_rand($items)];
    }

    private static function resetSlots(int $amount) {
        self::$slots = [];

        for($i = 0; $i < $amount; $i++) {
            self::$slots[$i] = [];
        }

        return self::$slots;
    }
}
