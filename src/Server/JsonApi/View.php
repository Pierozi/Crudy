<?php

namespace Crudy\Server\JsonApi;

class View implements \Hoa\View\Viewable
{
    /**
     * @var Document
     */
    protected $document;

    /**
     * @var \SplObjectStorage
     */
    protected $resources;

    /**
     * @var bool
     */
    protected $noContent = false;

    public function __construct(Document $document)
    {
        $this->document = $document;
        $this->resources = new \SplObjectStorage();
    }

    /**
     * Get the JsonApi document class
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Define view to return nothing
     * @param bool $noContent
     */
    public function noContent(bool $noContent = true, int $httpCode = 204)
    {
        $this->noContent = $noContent;
        $this->document->setHttpCode($httpCode);
    }

    /**
     * add resource to ObjectStorage
     * @param Resource $resource
     */
    public function addResource(\Crudy\Server\JsonApi\Resource $resource)
    {
        $this->resources->attach($resource);
    }

    public function dropResources()
    {
        $this->resources = null;
        $this->resources = new \SplObjectStorage();
    }

    /**
     * @description 'Get the output stream.';
     * @ensures \result: \Hoa\Stream\IStream\Out;
     */
    public function getOutputStream()
    {
        return 'php://output';
    }

    /**
     * @description 'Get the data send to the resource extract from http body';
     */
    public function getData()
    {
        return $this->document->extractData();
    }

    /**
     * @description 'Get the attributes node of data send to the resource extract from http body';
     */
    public function getAttributes()
    {
        $data = $this->document->extractData();

        if (null === $data) {
            return $data;
        }

        return $data->attributes;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        $data = $this->document->extractData();

        if (null === $data || !isset($data->id)) {
            return null;
        }

        //TODO check if ID is authorized ID - check regexp of dispatcher

        return $data->id;
    }

    /**
     * @description 'Make a render of the view.';
     * @ensures \result: void;
     */
    public function render()
    {
        $httpCode = $this->document->getHttpCode();
        header($_SERVER['SERVER_PROTOCOL']." $httpCode " . Exception::HTTP_STATUS[$httpCode], null, $httpCode);

        if (true === $this->noContent) {

            return;
        }

        header('Content-Type: ' . Document::CONTENT_TYPE);
        $response = $this->document->response($this->resources);
        
        file_put_contents($this->getOutputStream(), $response);
    }

    /**
     * @description 'Get router.';
     * @ensures \result: \Hoa\Router;
     */
    public function getRouter()
    {
    }
}