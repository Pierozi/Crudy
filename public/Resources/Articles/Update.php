<?php

namespace CrudyApplication\Resources\Articles;

use Crudy\Server\Crud\UpdateInterface;

class Update extends Resource implements UpdateInterface
{
    public function update(string $resourceId)
    {
        $attributes = $this->view->getData();

        $this->createResource($resourceId, $attributes);
    }
}