<?php

namespace Crudy\Server\Cors;

use Plab\ValueObject\ValueObject;

class CorsVo extends ValueObject
{
    const ACCESS = [
        'Access-Control-Allow-Origin',
        'Access-Control-Expose-Headers',
        'Access-Control-Max-Age',
        'Access-Control-Allow-Credentials',
        'Access-Control-Allow-Methods',
        'Access-Control-Allow-Headers',
        'Origin',
        'Access-Control-Request-Method',
        'Access-Control-Request-Headers',
    ];

    public $key;
    public $value;

    /**
     * CorsVo constructor.
     * @param string $key
     * @param string $value
     */
    public function __construct(string $key, string $value)
    {
        $this->check($key);

        if ('Access-Control-Allow-Credentials' === $key && 'true' !== $value && 'false' !== $value) {
            throw new CorsVoValueException('The value for Allow-Credentials must be true or false');
        }

        if ('Access-Control-Allow-Origin' === $key && '*' === $value) {
            throw new CorsVoDeprecatedException('Usage of wildcard in Allow-Origin is now deprecated by recent browser');
        }

        $this->key   = $key;
        $this->value = $value;
    }

    public function equal(ValueObject $left, ValueObject $right)
    {
        return ($left->key === $right->key && $left->value === $right->value);
    }

    protected function check(string $key)
    {
        if (false === in_array($key, self::ACCESS)) {
            throw new CorsVoUnknownException(sprintf('This CORS key %s is not valid', $key));
        }
    }
}