<?php

namespace Crudy\Server;
use Crudy\Server\JsonApi\Resource;
use Crudy\Server\JsonApi\View;
use Hoa\Router;

/**
 * Class Resource
 * @package Crudy\Server
 */
class Kit extends \Hoa\Dispatcher\Kit
{
    /**
     * @var \Crudy\Server\JsonApi\Document
     */
    protected $document;

    /**
     * @var string
     */
    protected $type;
    
    /**
     * The view.
     *
     * @var View
     */
    public $view       = null;

    public function __construct(Router $router, Dispatcher $dispatcher, View $view)
    {
        parent::__construct($router, $dispatcher, $view);

        $this->document = $view->getDocument();

        $reflection = new \ReflectionClass(static::class);
        $this->type = mb_strtolower($reflection->getShortName());
    }
    
    protected function purge()
    {
        $this->view->dropResources();
    }

    protected function addResource(string $id = null, array $attributes)
    {
        $resource = new Resource($this->type, $id, $attributes);
        
        $this->view->addResource($resource);
    }
}