<?php

namespace CrudyApplication\Resources\Data\Without\Attribute;

use CrudyApplication\Resources\Resource;
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