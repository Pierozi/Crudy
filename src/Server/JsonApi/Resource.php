<?php

namespace Crudy\Server\JsonApi;

use Hoa\Consistency\Consistency;
use Hoa\Exception\Exception;

class Resource
{
    /**
     * @var string type of resource
     */
    protected $type;

    /**
     * @var string id of resource
     */
    protected $id;
    
    /**
     * @var array of attributes
     */
    protected $attributes;
    
    public function __construct(string $type, string $id = null, array $attributes = null)
    {
        $this->type       = $type;
        $this->id         = Consistency::uuid();
        $this->attributes = $attributes;
    }

    /**
     * Return resource represented as jsonApi specification
     * @return array
     */
    public function toJson()
    {
        return [
            "type"       => $this->type,
            "id"         => $this->id,
            "attributes" => $this->attributes,
        ];
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function __toString()
    {
        $response = json_encode($this->toJson());
        
        if (!is_string($response)) {
            
            throw new Exception('Cannot convert resource object into string');
        }
        
        return $response;
    }
}