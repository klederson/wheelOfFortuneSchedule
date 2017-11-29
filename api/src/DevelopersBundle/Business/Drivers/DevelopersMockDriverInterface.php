<?php

namespace DevelopersBundle\Business\Drivers;

use ApplicationBundle\Communication\DataTransferObjects\DevelopersDto;

/**
 * Interface DevelopersMockInterface
 *
 * This is the most important part of the abstraction because as per definition everything implementing this interface
 * should communicate in the same way.
 *
 * Usually the Driver is one of the most granular levels of the application (the most one would be thirdpart tools like
 * SDKs for example). Because of this granularity the ideal is to keep as much as possible complexity out of the responses
 * so I choose (this is not a rule but is indeed a good practice to make the code as much reusable and easy to change
 * as possible) to return the DTOs already instead of Entities for example.
 *
 * @package DevelopersBundle\Business\Drivers
 */
interface DevelopersMockDriverInterface
{
    /**
     * @return array|DevelopersDto
     */
    public function getDevelopers() : array;

    /**
     * @param mixed $uuid;
     *
     * @return DevelopersDto
     */
    public function getDeveloper($uuid);
}
