<?php

namespace Application\Resources\Data\Without\Attribute;

use Application\Resources\Resource;
use Crudy\Server\Crud\ReadInterface;

class Read extends Resource implements ReadInterface
{
    public function read(string $resourceId)
    {
        $this->createResource(null, []);
    }

    public function readAll()
    {
        $this->createResource(null, []);
        $this->createResource(null, []);
    }
}