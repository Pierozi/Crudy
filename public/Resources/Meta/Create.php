<?php

namespace CrudyApplication\Resources\Meta;

use CrudyApplication\Resources\Resource;
use Crudy\Server\Crud\CreateInterface;

class Create extends Resource implements CreateInterface
{
    public function create()
    {
        $this->document
            ->hideVersion()
            ->setMeta('copyright', 'Copyright 2015 Example Corp.')
            ->setMeta('authors', [
                'Yehuda Katz',
                'Steve Klabnik',
                'Dan Gebhardt',
                'Tyler Kellen',
            ])
        ;
    }
}
