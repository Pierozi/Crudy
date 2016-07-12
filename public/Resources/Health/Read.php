<?php

namespace Application\Resources\Health;

use Crudy\Server\Crud\ReadInterface;
use Crudy\Server\JsonApi\Exception;
use Crudy\Server\Kit;

class Read implements ReadInterface
{
    public function read(Kit $_this, string $resourceId)
    {
        //TODO not supported
    }

    public function readAll(Kit $_this)
    {
        /*echo __METHOD__, "\n";

        $_this->view->getData();*/

        //TODO replace by real usecase when view ready

        throw new Exception('JsonView not yet implemented', 200);
    }
}