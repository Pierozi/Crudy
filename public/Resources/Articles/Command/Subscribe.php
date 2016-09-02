<?php

namespace CrudyApplication\Resources\Articles\Command;

use Crudy\Server\Crud\CommandInterface;
use CrudyApplication\Resources\Articles\Resource;

class Subscribe extends Resource implements CommandInterface
{
    public function exec(string $resourceId)
    {
        if ('foo.bar' === $this->data->topic) {
            $this->view->noContent();
        }
    }

    public function describe()
    {
    }
}
