<?php

namespace Crudy\Server\JsonApi;

use Hoa\Router\Http\Http;
use Hoa\Router\Router;

class Document
{
    const CONTENT_TYPE = 'application/vnd.api+json';
    const SPECIFICATION_VERSION = '1.0';

    protected static $headers;

    protected $router;
    protected $bodyAsJson;
    protected $responseHttpCode = 200;
    protected $meta = [];
    protected $corsList = [];

    /**
     * Document constructor.
     * @param Http $router
     */
    public function __construct(Http $router, Array $CorsList = [])
    {
        $this->router = $router;
        $this->corsList = $CorsList;

        $this->meta = [
            "jsonapi" => [
                "version" => self::SPECIFICATION_VERSION
            ]
        ];
    }

    public function addCors(\Crudy\Server\Cors\CorsVo $corsVo)
    {
        $this->corsList[$corsVo->key] = $corsVo;
    }

    /**
     * cross-origin HTTP request
     * @throws Exception
     */
    public function crossOriginResourceSharing()
    {
        foreach ($this->corsList as $corsVo) {

            if ('Access-Control-Allow-Headers' === $corsVo->key
                && false === array_key_exists('HTTP_ACCESS_CONTROL_REQUEST_HEADERS', $_SERVER)
            ) {
                continue;
            }

            header($corsVo->key . ': ' . $corsVo->value);
        }

        if ('OPTIONS' === $_SERVER['REQUEST_METHOD']) {

            if (array_key_exists('HTTP_ACCESS_CONTROL_REQUEST_METHOD', $_SERVER)) {
                header('Access-Control-Allow-Methods: POST, GET, PATCH, DELETE, PUT, HEAD');
            }

            throw new Exception('CORS WebServer avoid result', 200);
        }
    }

    /**
     * @throws Exception
     */
    public function headerResponsibilities()
    {
        $contentType = null;
        $method      = $this->router->getMethod();
        $rule        = $this->router->getTheRule();

        if (in_array($rule[Router::RULE_ID], ['cmdE', 'cmdD'])) {
            return;
        }

        if (array_key_exists('HTTP_CONTENT_TYPE', $_SERVER)) {

            list($contentType) = explode(';', $_SERVER['HTTP_CONTENT_TYPE']);

        } elseif (array_key_exists('CONTENT_TYPE', $_SERVER)) {

            list($contentType) = explode(';', $_SERVER['CONTENT_TYPE']);
        }

        if (!array_key_exists('HTTP_ACCEPT', $_SERVER)
            || (self::CONTENT_TYPE !== $_SERVER['HTTP_ACCEPT'] && '*/*' !== $_SERVER['HTTP_ACCEPT'])
        ) {
            throw new Exception('Header must Accept application/vnd.api+json', 406);
        }

        if (in_array($method, ['post', 'patch', 'put'])
            && self::CONTENT_TYPE !== $contentType
            && 'multipart/form-data' !== $contentType
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

            return $this->bodyAsJson->data;
        }
        
        $input = file_get_contents('php://input');
        $this->bodyAsJson = json_decode($input);

        if (    null === $this->bodyAsJson
            || false === isset($this->bodyAsJson->data)
        ) {
            return $this->bodyAsJson = null;
        }

        return $this->bodyAsJson->data;
    }

    /**
     * @param \SplObjectStorage $resources
     */
    public function response(\SplObjectStorage $resources)
    {
        $data = [];

        foreach ($resources as $resource) {

            $data[] = $resource->toJson();
        }

        $rule = $this->router->getTheRule();

        if (in_array($rule[Router::RULE_ID], ['cr', 'rr', 'ur'])
            && 0 !== count($data)
        ) {
            $data = current($data);
        }

        $response['data'] = $data;

        if (0 < count($this->meta)) {

            $response['meta'] = $this->meta;
        }

        return json_encode($response);
    }

    /**
     * @return int
     */
    public function getHttpCode()
    {
        $rule = $this->router->getTheRule();

        if (    200 === $this->responseHttpCode
            && 'cr' === $rule[Router::RULE_ID]
        ) {
            return 201;
        }

        return $this->responseHttpCode;
    }

    /**
     * @param $code
     * @return $this
     * @throws Exception
     */
    public function setHttpCode($code)
    {
        if (false === in_array($code, array_keys(Exception::HTTP_STATUS))) {
            
            throw new Exception('Http code specified are not supported', 400);
        }
        
        $this->responseHttpCode = $code;

        return $this;
    }

    /**
     * Hide JsonApi version into top level meta
     * @param bool $hidden default true
     * @return $this
     */
    public function hideVersion(bool $hidden = true)
    {
        if (true === $hidden
            && array_key_exists('jsonapi', $this->meta)
        ) {
            unset($this->meta['jsonapi']);
            return $this;
        }

        $this->meta['jsonapi'] = [
            "version" => self::SPECIFICATION_VERSION
        ];

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     * @throws Exception
     */
    public function setMeta(string $key, $value)
    {
        if ('jsonapi' === $key) {

            throw new Exception('The meta '. $key .' are reserved for JsonApi protocol, thranks to use another key');
        }

        $this->meta[$key] = $value;

        return $this;
    }

    /**
     * Return specific Header
     *
     * @param string $key
     * @return null
     */
    public function getHeader(string $key)
    {
        $key     = mb_strtoupper($key);
        $headers = $this->getHeaders();

        if (array_key_exists($key, $headers)) {

            return $headers[$key];
        }

        return null;
    }

    /**
     * Extract HTTP Header from request
     *
     * @return array
     */
    public function getHeaders() : array
    {
        if (null !== static::$headers) {

            return static::$headers;
        }

        $headers = [];

        foreach ($_SERVER as $key => $value) {

            $key = mb_strtoupper($key);

            if ('HTTP_' !== substr($key, 0, 5)) {
                continue;
            }

            $key = str_replace('_', '-',
                substr($key, 5)
            );

            if ('false' === mb_strtolower($value)) {
                $value = false;
            }

            if ('true' === mb_strtolower($value)) {
                $value = true;
            }

            $headers[$key] = $value;
        }

        return static::$headers = $headers;
    }
}
