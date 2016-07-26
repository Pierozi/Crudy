<?php

namespace Crudy\Server;
use Crudy\Server\JsonApi\Document;
use Crudy\Server\JsonApi\Exception;
use Crudy\Server\JsonApi\View;
use Hoa\Event\Bucket;
use Hoa\Event\Event;
use Hoa\Router\Exception\NotFound;
use Hoa\Router\Http\Http;

/**
 * Class Server
 * @package Crudy\Server
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
    public function __construct ($resourcesNameSpace = '\Application\Resources')
    {
        //TODO must change namespace without default for avoid production use test class
        //TODO rename ns in correct test name for avoid confusion

        $this->resourcesNameSpace = $resourcesNameSpace;
        $this->router = new Http();

        $this->errorHandler();
        $this->registerRules();

        $this->document = new Document($this->router);
    }

    /**
     * Resolve actual request with Api rules
     */
    public function resolve()
    {
        $view = new View($this->document);

        $this->dispatcher = new Dispatcher([
            'resource.root.ns' => $this->resourcesNameSpace,
            'synchronous.call' => '(:%resource.root.ns:)\(:%variables.resourcename:U:)\(:call:U:)',
            'synchronous.able' => '(:able:)',
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
        $manyRegex   = '(?<resourceName>[a-z-]+)/?';
        
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

                    die($exception->toJson());
                }

                if ($exception instanceof NotFound || $exception instanceof \Hoa\Dispatcher\Exception) {

                    new Exception('Resource not found', 404);
                }

                if (defined('__DEV_MODE__')) {
                    throw new \Exception($exception->getMessage(), $exception->getCode(), $exception);
                }

                die('internal server error'); //TODO must implement jsonapi error format
            }
        );
    }
}