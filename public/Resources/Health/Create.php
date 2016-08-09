<?php

namespace CrudyApplication\Resources\Health;

use CrudyApplication\Resources\Resource;
use Crudy\Server\Crud\CreateInterface;

class Create extends Resource implements CreateInterface
{
    public function create()
    {
        $len = strlen(file_get_contents('php://input'));

        $this->createResource(
            '999',
            $this->data,
            [
                'body-length' => $len,
                't' => true,
                'f' => false,
                'n' => null,
                'foo' => [
                    'bar' => 'rab',
                    'baz' => 'zab',
                ],
            ]
        );
    }
}
