<?php

namespace DevelopersBundle;

use DevelopersBundle\Business\Drivers\DevelopersMockDriverCsv;
use DevelopersBundle\Business\Model\DevelopersStorage;
use ApplicationBundle\Communication\DataTransferObjects\DevelopersDto;

class DevelopersFacade
{
    private $storageService = null;

    public function __construct()
    {
        $driver = new DevelopersMockDriverCsv(); //this is hardcoded for the sake of the simplicity of the test and to keep the good usage of Dependency Injection
        $this->storageService = new DevelopersStorage($driver);
    }

    /**
     * @return array|DevelopersDto
     */
    public function getDevelopers() {
        return $this->storageService->getDevelopers();
    }

    /**
     * @param $uuid
     *
     * @return DevelopersDto
     */
    public function getDeveloper($uuid) {
        return $this->storageService->getDeveloper($uuid);
    }
}