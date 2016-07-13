<?php

namespace Crudy\Server\Crud;

interface ReadInterface
{
    public function read(string $resourceId);
    public function readAll();
}