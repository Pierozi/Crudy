<?php

require_once dirname(__DIR__)
    . DIRECTORY_SEPARATOR
    . 'vendor'
    . DIRECTORY_SEPARATOR
    . 'autoload.php'
;

include dirname(__DIR__) . DIRECTORY_SEPARATOR . 'tool.php';

//TODO IF DEV

define('__DEV_MODE__', true);

//TODO IF DEV

if (defined('__DEV_MODE__')) {
    ini_set('error_reporting', E_ALL);
    ini_set('display_errors', 1);
}

\Hoa\Exception\Error::enableErrorHandler(true);

/**
 * PHP Settings
 */
date_default_timezone_set('Europe/Paris');

$Server = new \JsonApi\Server\Server();
$Server->resolve();
