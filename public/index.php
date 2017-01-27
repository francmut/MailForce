<?php


/**
 * ------------------------------------------------------------------
 * Bootstrap The Application
 * ------------------------------------------------------------------
 *
 * This loads the composer autoloader, configures and initializes the 
 * application for us.
 *
 */

$app = require_once __DIR__.'/../app/bootstrap.php';


/**
 * ------------------------------------------------------------------
 * Run The Application
 * ------------------------------------------------------------------
 *
 * Once we have the application, we can handle the incoming requests 
 * and send the associated response back to the client's browser.
 *
 */

$app->run();
