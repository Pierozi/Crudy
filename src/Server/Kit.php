<?php

namespace Crudy\Server;
use Crudy\Server\JsonApi\Exception;
use Crudy\Server\JsonApi\Resource;
use Crudy\Server\JsonApi\View;
use Hoa\Router;

/**
 * Class Resource
 * @package Crudy\Server
 */
abstract class Kit extends \Hoa\Dispatcher\Kit
{
    const RESOURCE_TYPE_ACCEPTED = 'queue-jobs';

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

    /**
     * Kit constructor.
     * @param Router $router
     * @param Dispatcher $dispatcher
     * @param View $view
     */
    public function __construct(Router $router, Dispatcher $dispatcher, View $view)
    {
        parent::__construct($router, $dispatcher, $view);

        $this->document = $view->getDocument();
        $this->getType();
    }

    /**
     * @throws Exception
     */
    public function notFound()
    {
        throw new Exception('Resource not found', 404);
    }

    /**
     * @throws Exception
     */
    public function forbidden(string $message = "You're not authorized to create this resource.")
    {
        throw new Exception($message, 403);
    }

    /**
     * @return mixed|string
     */
    protected function getType()
    {
        $ns = explode('\\', static::class);

        return $this->type = mb_strtolower($ns[count($ns) - 2]);
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

    protected function acceptedResource(
        string $id
        , $attributes = null
        , string $type = self::RESOURCE_TYPE_ACCEPTED
    ) {
        $resource = new Resource($type, $id);

        if (null === $attributes) {

            $attributes = ['status' => 'Pending request, waiting other process'];
        }

        $resource
            ->setAttributes($attributes)
            ->fillLinks(['self' => $this->type . '/' . $type . '/' . $id])
        ;

        $this->view->addResource($resource);
        $this->document->setHttpCode(202);
    }
}