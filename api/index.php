<?php

require_once __DIR__ . '/app/kernel.php';

$app['debug'] = true;
$app->register(new Silex\Provider\ServiceControllerServiceProvider());

//Routes
$app['wheel.controller'] = function() use ($app) {
    return new \WheelOfFortuneBundle\Communication\Controllers\WheelOfFortuneController();
};

$app->get('/spin', "wheel.controller:indexAction");

//Let's do the magic
$app->run();
