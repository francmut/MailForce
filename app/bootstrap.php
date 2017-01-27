<?php

/**
 * Register the composer autoloader
 *
 */
require __DIR__.'/../vendor/autoload.php';

/**
 * Initialize phpdotenv
 *
 */
use Dotenv\Dotenv;

$dotenv = new Dotenv(__DIR__.'/../');
$dotenv->load();

/**
 * Setup the Symfony routes
 *
 */
$routes_config = require_once __DIR__.'/../share/config/routes.php';


/**
 * Initialize the application
 *
 */
$app = new \MailForce\App();

$app->initRoutes($routes_config);
 
return $app;
