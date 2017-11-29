<?php

namespace DevelopersBundle\Business\Model;

use DevelopersBundle\Business\Drivers\DevelopersMockDriverInterface;
use ApplicationBundle\Communication\DataTransferObjects\DevelopersDto;

class DevelopersStorage
{
    protected $driver = null;

    /**
     * DevelopersStorage: An exemplify how to use the Driver Abstraction approach together with Dependency Injection.
     *
     * @param DevelopersMockDriverInterface $driver
     */
    public function __construct(DevelopersMockDriverInterface $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @return array|DevelopersDto
     */
    public function getDevelopers() {
        return $this->driver->getDevelopers();
    }

    /**
     * @param string $uuid
     *
     * @return DevelopersDto
     */
    public function getDeveloper(string $uuid) {
        return $this->driver->getDeveloper($uuid);
    }
}