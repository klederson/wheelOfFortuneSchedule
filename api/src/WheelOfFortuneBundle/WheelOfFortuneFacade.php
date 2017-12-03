<?php

namespace WheelOfFortuneBundle;

use ApplicationBundle\Communication\DataTransferObjects\DevelopersDto;
use WheelOfFortuneBundle\Business\Model\WheelOfFortuneModel;

class WheelOfFortuneFacade
{
    /**
     * @param int $days
     * @param array|DevelopersDto $developers
     *
     * @return array
     */
    public function getRandomisedShifts(int $days, array $developers)
    {
        return WheelOfFortuneModel::randomiseShifts($days, $developers);
    }

    /**
     * @param int $days
     * @param array|DevelopersDto $developers
     *
     * @return array
     */
    public function spinTheWheel(int $days, array $developers)
    {
        return $this->getRandomisedShifts($days, $developers);
    }

    public function getDeveloperShifts(string $uuid) {
        return WheelOfFortuneModel::getDeveloperShifts($uuid);
    }
}
