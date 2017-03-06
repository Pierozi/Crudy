<?php

require_once dirname(__DIR__)
    .DIRECTORY_SEPARATOR
    .'vendor'
    .DIRECTORY_SEPARATOR
    .'autoload.php';

include dirname(__DIR__).DIRECTORY_SEPARATOR.'tool.php';

//TODO IF DEV

define('__DEV_MODE__', true);

//TODO IF DEV

if (defined('__DEV_MODE__')) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);

    define('C3_CODECOVERAGE_ERROR_LOG_FILE', dirname(__DIR__) . '/c3_error.log'); //Optional (if not set the default c3 output dir will be used)
    include dirname(__DIR__) . '/c3.php';
}

\Hoa\Exception\Error::enableErrorHandler(true);

/*
 * PHP Settings
 */
date_default_timezone_set('Europe/Paris');

$Server = new \Crudy\Server\Server('\CrudyApplication\Resources');

$Server
    ->cors(new \Crudy\Server\Cors\CorsVo('Access-Control-Allow-Credentials', 'true'))
    ->cors(new \Crudy\Server\Cors\CorsVo('Access-Control-Expose-Headers', 'set'))
    ->cors(new \Crudy\Server\Cors\CorsVo('Access-Control-Allow-Origin', 'http://localhost:8080'))
;

$Server->resolve();
