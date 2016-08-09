<?php

namespace Crudy\Server\Crud;

interface CommandInterface
{
    public function exec();
    public function describe();
}
