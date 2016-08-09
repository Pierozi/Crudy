<?php

namespace CrudyApplication\Resources\Data\Header;

use CrudyApplication\Resources\Resource;
use Crudy\Server\Crud\ReadInterface;

class Read extends Resource implements ReadInterface
{
    public function read(string $resourceId)
    {
        $headers = $this->document->getHeaders();
        $equal   = (
            $headers['X-AUTHORIZATION'] === $this->document->getHeader('x-authorization')
            && $headers['X-CRUDY-TU'] === $this->document->getHeader('X-CRUDY-TU')
            && $headers['X-BEHAT'] === $this->document->getHeader('X-BEHAT')
            && $headers['USER-AGENT'] === $this->document->getHeader('User-Agent')
        );

        $this->createResource(null, [
            'headers' => $headers,
            'equal'   => $equal,
        ]);
    }

    public function readAll()
    {
        $this->notFound();
    }
}