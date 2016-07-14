<?php

namespace Application\Resources\Meta;

use Application\Resources\Resource;
use Crudy\Server\Crud\ReadInterface;

class Read extends Resource implements ReadInterface
{
    public function read(string $resourceId)
    {
        $this->document->hideVersion();
    }

    public function readAll()
    {
    }
}