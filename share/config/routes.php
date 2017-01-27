<?php

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

$routes = new RouteCollection();

$routes->add('home', new Route('/', array(
        '_controller' => function () {
            return new Response('Loop ');
        }
    ))
);

$routes->add('send_mail', new Route('/mailto/{email}', array(
        '_controller' => 'MailForce\Controller\MailController::sendMail',
    ))
);

$routes->add('send_notification', new Route('/notify/{email}', array(
        '_controller' => 'MailForce\Controller\MailController::notify',
    ))
);

return $routes;
