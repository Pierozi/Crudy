<?php

namespace JsonApi\Server\Crud;

use JsonApi\Server\Kit;

interface ReadInterface
{
    public function read(Kit $_this, string $resourceId);
    public function readAll(Kit $kit);
}