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

        $schedule = $facade->getRandomisedShifts(10, $developers);

        foreach($schedule as $dayIndex => $dayAssignments) {
            $this->assertTrue(count($dayAssignments) === 2);
            $this->assertNotEquals($dayAssignments[0], $dayAssignments[1]);
        }
    }

    public function testAnEngineerCannotHaveHalfDayShiftsOnConsecutiveDays()
    {
        //An engineer cannot have half day shifts on consecutive days

        $facade = $this->getFacade();
        $developers = $this->getDevelopersFacade()->getDevelopers();

        $schedule = $facade->getRandomisedShifts(10, $developers);

        foreach($schedule as $dayIndex => $dayAssignments) {
            $previousDay = $dayIndex > 0 ? $dayIndex - 1 : $dayIndex;

            $this->assertTrue(count($schedule[$previousDay]) === 2);

            foreach($dayAssignments as $uuid) {
                $this->assertNotEquals($uuid, $schedule[$previousDay]);
            }
        }
    }

    public function testEachEngineerShouldHaveCompletedOneWholeDayOfSupportInAny2WeekPeriod()
    {
        //Each engineer should have completed one whole day of support in any 2 week period
        ini_set('memory_limit', '1024M');

        $minTime = 5;

        $facade = $this->getFacade();
        $developers = $this->getDevelopersFacade()->getDevelopers();

        $schedule = $facade->getRandomisedShifts(20, $developers);

        foreach($developers as $developer) {
            $previousDay = null;
            $uuid = $developer->getUuid();

            $developerShifts = $facade->getDeveloperShifts($uuid);

            $previousShift = false;
            foreach($developerShifts as $shift) {
                $this->assertNotTrue($shift - $previousShift > $minTime && $previousShift !== false);
            }
        }
    }

}