<?php

namespace CrudyApplication\Resources\Health;

use CrudyApplication\Resources\Resource;
use Crudy\Server\Crud\ReadInterface;

class Read extends Resource implements ReadInterface
{
    public function read(string $resourceId)
    {
        $this->createResource(null, [
            'devMode'            => defined('__DEV_MODE__'),
            'hasReceiveBodyData' => !is_null($this->data),
        ]);
    }

    public function readAll()
    {
        $this->createResource(null, [
            'devMode'            => defined('__DEV_MODE__'),
            'hasReceiveBodyData' => !is_null($this->data),
        ]);
    }
}