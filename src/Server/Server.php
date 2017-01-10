<?php

namespace Crudy\Server;

use Crudy\Server\JsonApi\Document;
use Crudy\Server\JsonApi\Exception;
use Crudy\Server\JsonApi\View;
use Hoa\Event\Bucket;
use Hoa\Event\Event;
use Hoa\Exception\Group;
use Hoa\Router\Exception\NotFound;
use Hoa\Router\Http\Http;

/**
 * Class Server.
 */
class Server
{
    /**
     * @var Http
     */
    protected $router;

    /**
     * @var Dispatcher
     */
    protected $dispatcher;

    /**
     * @var Document
     */
    protected $document;

    /**
     * @var string
     */
    protected $resourcesNameSpace;

    /**
     * Server constructor.
     */
    public function __construct($resourcesNameSpace = '\Application\Resources')
    {
        //TODO must change namespace without default for avoid production use test class
        //TODO rename ns in correct test name for avoid confusion

        $this->resourcesNameSpace = $resourcesNameSpace;
        $this->router = new Http();

        $this->errorHandler();
        $this->registerRules();

        $corsList = [
            new \Crudy\Server\Cors\CorsVo('Access-Control-Allow-Headers', 'origin, accept, content-type, authorization'),
        ];

        $this->document = new Document($this->router, $corsList);
    }

    /**
     * @param Cors\CorsVo $corsVo
     * @return $this
     */
    public function cors(\Crudy\Server\Cors\CorsVo $corsVo)
    {
        $this->document->addCors($corsVo);
        return $this;
    }

    /**
     * Resolve actual request with Api rules.
     */
    public function resolve()
    {
        $this->document->crossOriginResourceSharing();

        $view = new View($this->document);

        $this->dispatcher = new Dispatcher([
            'resource.root.ns' => $this->resourcesNameSpace,
            'synchronous.call' => '(:%resource.root.ns:)\(:%variables.resourcename:U:)\(:call:U:)',
            'synchronous.able' => '(:able:)',
            'command.call' => '(:%synchronous.call:)\(:%variables.commandname:U:)',
        ]);
        $this->dispatcher->setKitName(Kit::class);
        $this->dispatcher->dispatch($this->router, $view);

        $view->render();
    }

    /**
     *
     */
    protected function registerRules()
    {
        $singleRegex = '(?<resourceName>[a-z-]+)/(?<resourceId>[0-9a-zA-Z-]+)/?';
        $manyRegex = '(?<resourceName>[a-z-]+)/?';

        // Create resource rule
        $this->router
            ->post('cr', $manyRegex, 'Create', 'create')
        ;

        // Read resource rule
        $this->router
            ->get('rr', $singleRegex, 'Read', 'read')
        ;

        // Read many resource rule
        $this->router
            ->get('rar', $manyRegex, 'Read', 'readAll')
        ;

        // Update resource rule
        $this->router
            ->patch('ur', $singleRegex, 'Update', 'update')
        ;

        // Delete resource rule
        $this->router
            ->delete('dr', $singleRegex, 'Delete', 'delete')
        ;

        // Command resource rule
        $this->router
            ->post('cmdE', '(?<resourceName>[a-z-]+)/(?<resourceId>[0-9a-zA-Z-]+)/command/(?<commandName>[a-z-]+)?', 'Command', 'exec')
        ;

        // Describe Command resource rule
        $this->router
            ->head('cmdD', '(?<resourceName>[a-z-]+)/(?<resourceId>[0-9a-zA-Z-]+)/command/(?<commandName>[a-z-]+)?', 'Command', 'describe')
        ;
    }

    /**
     *
     */
    protected function errorHandler()
    {
        Event::getEvent('hoa://Event/Exception')->attach(
            function (Bucket $bucket) {
                $exception = $bucket->getData();

                if ($exception instanceof Exception) {

                    if ('OPTIONS' === $_SERVER['REQUEST_METHOD']) {
                        die;
                    }

                    die($exception->toJson());
                }

                if ($exception instanceof NotFound || $exception instanceof \Hoa\Dispatcher\Exception) {
                    new Exception('Resource not found', 404);
                }

                if ($exception instanceof Group) {

                    if (0 === $exception->getStackSize()) {
                        return;
                    }

                    die(Exception::groupToJson($exception));
                }

                if (defined('__DEV_MODE__')) {
                    throw new \Exception($exception->getMessage(), $exception->getCode(), $exception);
                }

                throw new Exception('Internal server error', 500);
            }
        );
    }
}
