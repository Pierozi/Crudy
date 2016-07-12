<?php

namespace Application\Resources\Articles;

use Crudy\Server\Crud\ReadInterface;
use Crudy\Server\Kit;

class Read extends Resource implements ReadInterface
{
    public function read(Kit $_this, string $resourceId)
    {
        echo __METHOD__, "\n";
        var_dump($resourceId);
    }

    public function readAll(Kit $_this)
    {
        echo __METHOD__, "\n";

        $_this->view->getData();
    }
}