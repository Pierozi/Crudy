<?php

namespace Application\Resources\Health;

use Application\Resources\Resource;
use Crudy\Server\Crud\ReadInterface;

class Read extends Resource implements ReadInterface
{
    public function read(string $resourceId)
    {
        $this->addResource(null, [
            'devMode'            => defined('__DEV_MODE__'),
            'hasReceiveBodyData' => !is_null($this->data),
        ]);
    }

    public function readAll()
    {
        $this->addResource(null, [
            'devMode'            => defined('__DEV_MODE__'),
            'hasReceiveBodyData' => !is_null($this->data),
        ]);
    }
}