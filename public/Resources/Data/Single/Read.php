<?php

namespace CrudyApplication\Resources\Data\Single;

use CrudyApplication\Resources\Resource;
use Crudy\Server\Crud\ReadInterface;

class Read extends Resource implements ReadInterface
{
    public function read(string $resourceId)
    {
        $this->createResource(null, [
            'foo' => 'bar',
            'baz' => 'foo',
        ]);
    }

    public function readAll()
    {
        $this->createResource(null, [
            'foo' => 'bar',
            'baz' => 'foo',
        ]);
    }
}
