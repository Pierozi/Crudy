<?php

namespace Crudy\Server\JsonApi;

class View implements \Hoa\View\Viewable
{
    /**
     * @description 'Get the output stream.';
     * @ensures \result: \Hoa\Stream\IStream\Out;
     */
    public function getOutputStream()
    {
    }

    /**
     * @description 'Get the data holded by the view.';
     */
    public function getData()
    {
    }

    /**
     * @description 'Make a render of the view.';
     * @ensures \result: void;
     */
    public function render()
    {
    }

    /**
     * @description 'Get router.';
     * @ensures \result: \Hoa\Router;
     */
    public function getRouter()
    {
    }
}