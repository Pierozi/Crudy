<?php

namespace Application\Resources\Health;

use Application\Resources\Resource;
use Crudy\Server\Crud\ReadInterface;
use Crudy\Server\JsonApi\Exception;

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