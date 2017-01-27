<?php

namespace MailForce\Listeners;

use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpFoundation\Response;

use Sunspikes\Ratelimit\Cache\Adapter\DesarrollaCacheAdapter;
use Sunspikes\Ratelimit\Cache\Factory\DesarrollaCacheFactory;
use Sunspikes\Ratelimit\Throttle\Throttler\CacheThrottler;
use Sunspikes\Ratelimit\Throttle\Factory\ThrottlerFactory;
use Sunspikes\Ratelimit\Throttle\Hydrator\HydratorFactory;
use Sunspikes\Ratelimit\RateLimiter;

class RequestListener {

    /**
     * Handles kernel.request events, the object is to rate limit calls to the /mailto/{email} route
     *
     * @param  Symfony\Component\HttpKernel\Event\GetResponseEvent    $event    The HttpKernel event object
     */
    public function onKernelRequest(GetResponseEvent $event) {

        // Limit the number of requests to this number
        $limit = getenv('RATE_LIMIT');

        // Limit the requests within this duration (seconds)
        $window = getenv('RATE_WINDOW');

        $cache_config = __DIR__.'/../../../share/config/cache.php';
        $cache_adapter = new DesarrollaCacheAdapter((new DesarrollaCacheFactory($cache_config))->make());
        $rate_limiter = new RateLimiter(new ThrottlerFactory(), new HydratorFactory(), $cache_adapter, $limit, $window);

        $mail_throttler = $rate_limiter->get('/mailto');
        $notify_throttler = $rate_limiter->get('/notify');
        

        $request  = $event->getRequest()->getRequestUri();
        if (strpos($request, 'mailto')) {

            $mail_throttler->hit();
            
        }

        if (strpos($request, 'notify')) {

            $notify_throttler->hit();
            
        }

        if (!$mail_throttler->access()) {
            
            $payload = array(
                'status' => 'error',
                'message' => 'Too many requests'
            );
            $event->setResponse(new Response(json_encode($payload), 200, array('content-type' => 'application/json')));

        }
        
    }

}