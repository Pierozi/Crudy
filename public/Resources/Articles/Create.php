<?php

namespace CrudyApplication\Resources\Articles;

use Crudy\Server\Crud\CreateInterface;
use Hoa\Consistency\Consistency;

class Create extends Resource implements CreateInterface
{
    public function create()
    {
        $id = $this->view->getId();
        $attributes = $this->view->getAttributes();

        if (!empty($id)) {
            $this->view->noContent();

            return;
        }

        if (isset($attributes->accepted) && true === $attributes->accepted) {
            $this->acceptedResource(Consistency::uuid());

            return;
        }

        if (isset($attributes->forbidden) && true === $attributes->forbidden) {
            $this->forbidden();

            return;
        }

        $this->createResource($id, $attributes);
    }
}
