<?php

namespace DevelopersBundle\Tests;

use ApplicationBundle\Communication\DataTransferObjects\DevelopersDto;
use DevelopersBundle\Business\Drivers\DevelopersMockDriverCsv;
use DevelopersBundle\Business\Model\DevelopersStorage;
use PHPUnit\Framework\TestCase;


class DevelopersStorageTest extends TestCase
{
    private function getStorageService() {
        $driver = new DevelopersMockDriverCsv();
        return new DevelopersStorage($driver);
    }

    public function testGetDevelopersReturnArray() : void
    {
        $storageService = $this->getStorageService();
        $developers = $storageService->getDevelopers();

        $this->assertTrue(is_array($developers));
    }

    public function testGetDevelopersReturnArrayWithResults() : void
    {
        $storageService = $this->getStorageService();
        $developers = $storageService->getDevelopers();

        $this->assertTrue(is_array($developers));

        $this->assertTrue(count($developers) > 0 );
    }

    public function testGetDevelopersArrayInstanceTypeOfDevelopersDto(): void
    {
        $storageService = $this->getStorageService();
        $developers = $storageService->getDevelopers();

        foreach($developers as $developer) {
            $this->assertInstanceOf(
                DevelopersDto::class,
                $developer
            );
        }
    }

    public function testGetDeveloperByUuid(): void
    {
        $storageService = $this->getStorageService();
        $developers = $storageService->getDevelopers();

        foreach($developers as $developer) {
            /** @var $developer DevelopersDto */
            $currentResult = $storageService->getDeveloper($developer->getUuid());

            $this->assertEquals($currentResult->getUuid(), $developer->getUuid());
            $this->assertEquals($currentResult->getFirstName(), $developer->getFirstName());
            $this->assertEquals($currentResult->getLastName(), $developer->getLastName());
        }
    }

    public function testGetDeveloperByUuidShouldFail(): void
    {
        $storageService = $this->getStorageService();
        $developers = $storageService->getDevelopers();

        foreach($developers as $developer) {
            $currentResult = $storageService->getDeveloper(rand(0,100));

            $this->assertEquals($currentResult, false);
        }
    }
}