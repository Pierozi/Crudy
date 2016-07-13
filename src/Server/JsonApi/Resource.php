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

    /**
     * @var array of resource meta
     */
    protected $meta = [];

    /**
     * Resource constructor.
     * @param string $type
     * @param string|null $id
     * @param array|null $attributes
     */
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
        $response = [
            "type"       => $this->type,
            "id"         => $this->id,
            "attributes" => $this->attributes,
        ];

        if (0 < count($this->meta)) {

            $response['meta'] = $this->meta;
        }

        return $response;
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

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function setMeta(string $key, $value)
    {
        $this->meta[$key] = $value;

        return $this;
    }

    /**
     * Merge meta array with existent
     * @param array|null $meta
     * @param bool $purge for drop existent value
     * @return $this
     */
    public function fillMeta($meta = null, bool $purge = false)
    {
        if (null === $meta) {
            return $this;
        }

        if (true === $purge) {

            $this->meta = [];
        }

        $this->meta += $meta;

        return $this;
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param string $key
     * @param $value
     * @return $this
     */
    public function setAttribute(string $key, $value)
    {
        $this->attributes[$key] = $value;

        return $this;
    }
}