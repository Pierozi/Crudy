<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

use Flow\JSONPath\JSONPath;
use Flow\JSONPath\JSONPathException;

class Api extends \Codeception\Module
{
    /**
     * @param $path expected JSONPath expression syntax
     * @throws \Codeception\Exception\ModuleException
     */
    public function cantSeeResponseJsonMatchesPath($expression)
    {
        $response = $this->getModule('REST')->response;
        $response = json_decode($response);

        if (null === $response) {

            $this->assertFalse(true, 'Response is not in Json Format');
        }

        $jsonPath = new JSONPath($response);

        try {
            $jsonResult = $jsonPath->find($expression);
        } catch (JSONPathException $e) {
            $this->assertTrue(true, 'Xpath not found in json response');
        }

        if (false === $jsonResult->valid()) {
            $this->assertTrue(true, 'Xpath not found in json response');
            return;
        }

        $this->assertFalse(true, "$expression found response => \n" . json_encode($jsonResult->data()));
    }
}
