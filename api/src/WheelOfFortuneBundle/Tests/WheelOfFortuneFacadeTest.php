<?php

namespace WheelOfFortuneBundle\Tests;

use DevelopersBundle\DevelopersFacade;
use PHPUnit\Framework\TestCase;
use WheelOfFortuneBundle\WheelOfFortuneFacade;


class WheelOfFortuneFacadeTest extends TestCase
{
    private function getFacade() {
        return new WheelOfFortuneFacade();
    }

    private function getDevelopersFacade() {
        return new DevelopersFacade();
    }

    public function testAnEngineerCanDoAtMostOneHalfDayShiftInADay()
    {
        //An engineer can do at most one half day shift in a day

        $facade = $this->getFacade();
        $developers = $this->getDevelopersFacade()->getDevelopers();

        $schedule = $facade->getSupportSchedule(10, $developers);

        foreach($schedule['days'] as $dayIndex => $dayAssignments) {
            $this->assertTrue(count($dayAssignments) === 2);
            $this->assertNotEquals($dayAssignments[0], $dayAssignments[1]);
        }
    }

    public function testAnEngineerCannotHaveHalfDayShiftsOnConsecutiveDays()
    {
        //An engineer cannot have half day shifts on consecutive days

        $facade = $this->getFacade();
        $developers = $this->getDevelopersFacade()->getDevelopers();

        $schedule = $facade->getSupportSchedule(rand(10,10000), $developers);
        $currentDate = new \DateTime();

        foreach($schedule['days'] as $dayIndex => $dayAssignments) {
            $newDate = new \DateTime($dayIndex);
            $interval = $currentDate->diff($newDate);
            $dayIndexInterval = $interval->format('%a');

            $previousDay = $dayIndexInterval === "0" ? $newDate : $newDate->modify("-1 days");
            $previousDayIndex = $previousDay->format("Y-m-d");

            $this->assertTrue(count($schedule['days'][$previousDayIndex]) === 2);

            foreach($dayAssignments as $uuid) {
                $this->assertNotEquals($uuid, $schedule['days'][$previousDayIndex]);
            }
        }
    }

}