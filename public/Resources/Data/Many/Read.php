<?php

namespace CrudyApplication\Resources\Data\Many;

use CrudyApplication\Resources\Resource;
use Crudy\Server\Crud\ReadInterface;

class Read extends Resource implements ReadInterface
{
    public function read(string $resourceId)
    {
        $this->notFound();
    }

    public function readAll()
    {
        $this->createResource(null, [
            'foo' => 'bar',
            'baz' => 'foo',
        ]);

        $this->createResource(null, [
            'foo2' => 'bar2',
            'baz2' => 'foo2',
        ]);
    }
}