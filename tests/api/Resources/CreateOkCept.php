<?php

$I = new ApiTester($scenario);
$I->wantTo('Create new resource');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->haveHttpHeader('Content-Type', 'application/vnd.api+json');

$data = json_encode([
    "data" => [
        "type"       => "articles",
        "attributes" => [
            "foo" => "bar",
            "baz" => true,
        ],
    ],
]);

$I->sendPOST('/articles', $data);
$I->seeResponseCodeIs(201);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');

$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data.type');
$I->seeResponseJsonMatchesJsonPath('$.data.id');
$I->seeResponseJsonMatchesJsonPath('$.data.attributes');
$I->seeResponseJsonMatchesJsonPath('$..[?(@.type == "articles")]');
$I->seeResponseContains('{"foo":"bar","baz":true}');
