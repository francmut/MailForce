<?php

return [

    /**
     * ----------------------------------------------------------------------
     * Default Time To Live for cached data
     * ----------------------------------------------------------------------
     *
     * Provide your prefered default ttl value
     *
     */

    'default_ttl' => 3600,
    
    /**
     * ----------------------------------------------------------------------
     * Cache driver
     * ----------------------------------------------------------------------
     *
     * Available options file, apc, memory, mongo, mysql, redis, memcache
     *
     */

    'driver' => 'file',

    /**
     * ----------------------------------------------------------------------
     * Cache driver settings
     * ----------------------------------------------------------------------
     *
     * setup the cache driver
     *
     */
     
    'file' => [
        'cache_dir' => __DIR__.'/../..'.getenv('CACHE_PATH')
    ]
    
];