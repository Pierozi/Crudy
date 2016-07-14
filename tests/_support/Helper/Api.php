<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Flow\JSONPath\JSONPath;
use Flow\JSONPath\JSONPathException;

class Api extends \Codeception\Module
{
    public function seeResponseJsonArrayCountEqual($expression, $nb)
    {
        $jsonResult = $this->jsonPathFind($expression);
        $count = count($jsonResult->data()[0]);

        if ($nb === $count) {

            $this->assertTrue(true);

            return;
        }

        $this->assertFalse(true, "Xpath array must contain $nb lines instead $count");
    }

    /**
     * @param $expression
     * @return static
     * @throws \Codeception\Exception\ModuleException
     */
    public function jsonPathFind($expression)
    {
        $response = $this->getModule('REST')->response;
        $response = json_decode($response);

        if (null === $response) {

            $this->assertFalse(true, 'Response is not in Json Format');
        }

        $jsonPath = new JSONPath($response);

        return $jsonPath->find($expression);
    }
}
