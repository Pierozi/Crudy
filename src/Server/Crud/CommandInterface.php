<?php

namespace Crudy\Server\Crud;

interface CommandInterface
{
    public function exec(string $resourceId);
    public function describe();
}
