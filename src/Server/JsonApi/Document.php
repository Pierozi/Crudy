<?php

namespace Crudy\Server\JsonApi;

use Hoa\Router\Http\Http;

class Document
{
    const CONTENT_TYPE = 'application/vnd.api+json';

    protected $router;

    public function __construct (Http $router)
    {
        $this->router = $router;
        $this->headerResponsibilities();
    }

    public function headerResponsibilities()
    {
        $contentType = null;
        $method      = $this->router->getMethod();

        header('Access-Control-Expose-Headers: set');
        header('Access-Control-Allow-Origin: *');

        if ('OPTIONS' === $_SERVER['REQUEST_METHOD']
            && array_key_exists('HTTP_ACCESS_CONTROL_REQUEST_METHOD', $_SERVER)
        ) {
            header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE');
            exit;
        }

        if (array_key_exists('HTTP_CONTENT_TYPE', $_SERVER)) {

            list($contentType) = explode(';', $_SERVER['HTTP_CONTENT_TYPE']);
        }

        if (!array_key_exists('HTTP_ACCEPT', $_SERVER)
            || self::CONTENT_TYPE !== $_SERVER['HTTP_ACCEPT']
        ) {
            throw new Exception('Header must Accept Json-Api Protocol', 406);
        }

        if (('post' === $method || 'put' === $method)
            && self::CONTENT_TYPE !== $contentType
        ) {
            throw new Exception('Unsupported Media Type', 415);
        }
    }
}