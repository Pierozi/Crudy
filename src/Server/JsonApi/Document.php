<?php

namespace Crudy\Server\JsonApi;

use Hoa\Router\Http\Http;

class Document
{
    const CONTENT_TYPE = 'application/vnd.api+json';
    const SPECIFICATION_VERSION = '1.0';

    protected $router;
    protected $bodyAsJson;
    protected $responseHttpCode = 200;

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

    /**
     * Extract data node from body request as JsonAPI implementation describe
     * @return mixed null | object json
     */
    public function extractData()
    {
        if (null !== $this->bodyAsJson) {
            
            return $this->bodyAsJson;
        }
        
        $input = file_get_contents('php://input');
        
        return $this->bodyAsJson = json_decode($input);
    }

    /**
     * @param \SplObjectStorage $resources
     */
    public function response(\SplObjectStorage $resources)
    {
        $data = [];

        if (1 === $resources->count()) {

            $data = $resources->current();
        }

        foreach ($resources as $resource) {

            $data[] = $resource->toJson();
        }

        $response = [
            "data" => $data,
            "meta" => [
                "jsonapi" => [
                    "version" => self::SPECIFICATION_VERSION
                ]
            ]
        ];

        return json_encode($response);
    }
    
    public function getHttpCode()
    {
        return $this->responseHttpCode;
    }
    
    public function setHttpCode($code)
    {
        if (in_array($code, Exception::HTTP_STATUS)) {
            
            throw new Exception('Http code specified are not supported');
        }
        
        $this->responseHttpCode = $code;
    }
}