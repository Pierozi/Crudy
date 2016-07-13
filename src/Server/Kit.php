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

    /**
     * Drop resources from view
     */
    protected function purge()
    {
        $this->view->dropResources();
    }

    /**
     * Create new resource and append to view
     * @param string|null $id
     * @param array $attributes
     * @param array $meta
     */
    protected function createResource(
        string $id = null,
        $attributes,
        $meta = null
    ) {
        $resource = new Resource($this->type, $id);

        $resource
            ->setAttributes($attributes)
            ->fillMeta($meta)
        ;

        $this->view->addResource($resource);
    }

    /**
     * Append resource object to view
     * @param Resource $resource
     */
    protected function addResource(Resource $resource)
    {
        $this->view->addResource($resource);
    }
}