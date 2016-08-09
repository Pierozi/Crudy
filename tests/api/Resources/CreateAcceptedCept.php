<?php

$I = new ApiTester($scenario);
$I->wantTo('Create new resource in asynchronous mode');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->haveHttpHeader('Content-Type', 'application/vnd.api+json');

$data = json_encode([
    "data" => [
        "type"       => "articles",
        "attributes" => [
            "accepted" => true,
        ],
    ],
]);

$I->sendPOST('/articles', $data);
$I->seeResponseCodeIs(202);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');

$I->seeResponseIsJson();
$response = json_decode($I->grabResponse());

$I->seeResponseJsonMatchesJsonPath('$.data.type');
$I->seeResponseJsonMatchesJsonPath('$.data.id');
$I->seeResponseJsonMatchesJsonPath('$.data.attributes');
$I->seeResponseJsonMatchesJsonPath('$.data.links');
$I->seeResponseJsonMatchesJsonPath('$..[?(@.type == "queue-jobs")]');
$I->seeResponseContains('{"status":"Pending request, waiting other process"}');

if ($response->data->links->self !== 'articles/queue-jobs/' . $response->data->id) {
    throw new \Codeception\Exception\ConditionalAssertionFailed('Resource queue jobs links not match');
}
