<?php

namespace WheelOfFortuneBundle\Communication\Controllers;

use DevelopersBundle\DevelopersFacade;
use Symfony\Component\HttpFoundation\JsonResponse;
use WheelOfFortuneBundle\WheelOfFortuneFacade;

class WheelOfFortuneController
{
    private $facade;

    public function __construct()
    {
        $this->facade = new WheelOfFortuneFacade();
    }

    public function indexAction()
    {
        $developersFacade = new DevelopersFacade();
        $developers = $developersFacade->getDevelopers();

        return new JsonResponse($this->facade->getRandomisedShifts(10, $developers));
    }
}