<?php

namespace Crudy\Server\Crud;

use Crudy\Server\Kit;

interface ReadInterface
{
    public function read(Kit $_this, string $resourceId);
    public function readAll(Kit $kit);
}