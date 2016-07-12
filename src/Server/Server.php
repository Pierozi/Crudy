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
     * Server constructor.
     */
    public function __construct ()
    {
        $this->router = new Http();

        $this->errorHandler();
        $this->registerRules();

        $this->document = new Document($this->router);
    }

    /**
     *
     */
    public function resolve()
    {
        $view = new View();

        $this->dispatcher = new Dispatcher([
            'resource.root.ns' => '\Application\Resources',
            'synchronous.call' => '(:%resource.root.ns:)\(:%variables.resourcename:U:)\(:call:U:)',
            'synchronous.able' => '(:able:)',
        ]);
        $this->dispatcher->setKitName(Kit::class);
        $this->dispatcher->dispatch($this->router, $view);

        //TODO using $view for analyse result
    }

    /**
     *
     */
    protected function registerRules()
    {
        // Create resource rule
        $this->router
            ->post('cr', '(?<resourceName>[a-z-]+)/?')
        ;

        // Read resource rule
        $this->router
            ->get('rr', '(?<resourceName>[a-z-]+)/(?<resourceId>[0-9a-fA-F-]+)/?', 'Read', 'read')
        ;

        // Read many resource rule
        $this->router
            ->get('rar', '(?<resourceName>[a-z-]+)/?', 'Read', 'readAll')
        ;

        // Update resource rule
        $this->router
            ->patch('ur', '(?<resourceName>[a-z-]+)/(?<resourceId>[0-9a-fA-F-]+)/?')
        ;

        // Delete resource rule
        $this->router
            ->delete('dr', '(?<resourceName>[a-z-]+)/(?<resourceId>[0-9a-fA-F-]+)/?')
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

                if ($exception instanceof NotFound) {

                    die('not found');
                }

                if (defined('__DEV_MODE__')) {
                    throw new \Exception($exception->getMessage(), $exception->getCode(), $exception);
                }

                die('internal server error'); //TODO must implement jsonapi error format
            }
        );
    }
}