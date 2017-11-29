<?php

namespace DevelopersBundle\Tests;

use ApplicationBundle\Communication\DataTransferObjects\DevelopersDto;
use DevelopersBundle\Business\Drivers\DevelopersMockDriverCsv;
use DevelopersBundle\Business\Model\DevelopersStorage;
use DevelopersBundle\DevelopersFacade;
use PHPUnit\Framework\TestCase;

class DevelopersFacadeTest extends TestCase
{
    private function getFacade() {
        return new DevelopersFacade();
    }

    public function testGetDevelopersReturnArray() : void
    {
        $facade = $this->getFacade();
        $developers = $facade->getDevelopers();

        $this->assertTrue(is_array($developers));
    }

    public function testGetDevelopersReturnArrayWithResults() : void
    {
        $facade = $this->getFacade();
        $developers = $facade->getDevelopers();

        $this->assertTrue(is_array($developers));

        $this->assertTrue(count($developers) > 0 );
    }

    public function testGetDevelopersArrayInstanceTypeOfDevelopersDto(): void
    {
        $facade = $this->getFacade();
        $developers = $facade->getDevelopers();

        foreach($developers as $developer) {
            $this->assertInstanceOf(
                DevelopersDto::class,
                $developer
            );
        }
    }

    public function testGetDeveloperByUuid(): void
    {
        $facade = $this->getFacade();
        $developers = $facade->getDevelopers();

        foreach($developers as $developer) {
            /** @var $developer DevelopersDto */
            $currentResult = $facade->getDeveloper($developer->getUuid());

            $this->assertEquals($currentResult->getUuid(), $developer->getUuid());
            $this->assertEquals($currentResult->getFirstName(), $developer->getFirstName());
            $this->assertEquals($currentResult->getLastName(), $developer->getLastName());
        }
    }

    public function testGetDeveloperByUuidShouldFail(): void
    {
        $facade = $this->getFacade();
        $developers = $facade->getDevelopers();

        foreach($developers as $developer) {
            $currentResult = $facade->getDeveloper(rand(0,100));

            $this->assertEquals($currentResult, false);
        }
    }
}