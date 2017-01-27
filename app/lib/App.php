<?php 

namespace MailForce;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpKernel\Controller\ArgumentResolver;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpKernel\EventListener\RouterListener;
use Symfony\Component\HttpKernel\HttpKernel;

class App {

    /**
     * The event dispatcher
     *
     * @var    Symfony\Component\EventDispatcher\EventDispatcher
     */
    private $dispatcher;

    /**
     * Initializes the event dispatcher
     *
     */
    public function __construct() {

        // Create our event dispatcher
        $this->dispatcher = new EventDispatcher();

    }

    /**
     * Initializes routes
     *
     * @param $config    array    Routes definition 
     *
     */
    public function initRoutes($config) {
        
        $matcher = new UrlMatcher($config, new RequestContext());
        $this->dispatcher->addSubscriber(new RouterListener($matcher, new RequestStack()));

    }

    /**
     * Setup the HttpKernel and start handling incoming requests
     *
     */
    public function run() {

        // the request object 
        $request = Request::createFromGlobals();

        // create the controller resolver
        $controllerResolver = new ControllerResolver();

        // ... and the arguments resolver
        $argumentsResolver = new ArgumentResolver();

        // add event listeners
        $request_listener = new Listeners\RequestListener;
        $this->dispatcher->addListener('kernel.request', array($request_listener, 'onKernelRequest'));

        $kernel = new HttpKernel($this->dispatcher, $controllerResolver, new RequestStack(), $argumentsResolver);

        $response = $kernel->handle($request);

        $response->send();

        $kernel->terminate($request, $response);

    }

}