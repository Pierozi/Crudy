<?php

namespace CrudyApplication\Resources\Articles;

use Crudy\Server\Crud\DeleteInterface;

class Delete extends Resource implements DeleteInterface
{
    public function delete(string $resourceId)
    {
        $this->view->noContent();
    }
}