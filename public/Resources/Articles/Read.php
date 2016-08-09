<?php

namespace CrudyApplication\Resources\Articles;

use Crudy\Server\Crud\ReadInterface;

class Read extends Resource implements ReadInterface
{
    public function read(string $resourceId)
    {
        if ('42' !== $resourceId) {
            $this->notFound();
        }

        $this->createResource($resourceId, [
            'foo' => 'bar',
            'baz' => true,
        ]);
    }

    public function readAll()
    {
        $this->createResource(1, [
            'foo'   => 'bar',
            'baz'   => false,
            'dummy' => 'lipsum'
        ]);

        $this->createResource(42, [
            'foo' => 'bar',
            'baz' => true
        ]);
    }
}