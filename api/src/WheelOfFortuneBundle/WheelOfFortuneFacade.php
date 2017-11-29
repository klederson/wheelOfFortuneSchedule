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
    public function getSupportSchedule(int $days, array $developers)
    {
        return WheelOfFortuneModel::getDevelopersSchedule($days, $developers);
    }

    /**
     * @param int $days
     * @param array|DevelopersDto $developers
     *
     * @return array
     */
    public function spinTheWheel(int $days, array $developers)
    {
        return $this->getSupportSchedule($days, $developers);
    }
}
