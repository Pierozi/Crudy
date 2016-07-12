<?php

namespace Application\Resources\Health;

use JsonApi\Server\Crud\ReadInterface;
use JsonApi\Server\Kit;

class Read implements ReadInterface
{
    public function read(Kit $_this, string $resourceId)
    {
        //TODO not supported
    }

    public function readAll(Kit $_this)
    {
        echo __METHOD__, "\n";

        $_this->view->getData();
    }
}