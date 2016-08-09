<?php

$I = new ApiTester($scenario);
$I->wantTo('Input data are interpreted when trying create resource');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->haveHttpHeader('Content-Type', 'application/vnd.api+json');
$I->sendPOST('/health', '{ "data": { "type": "health", "attributes": { "title": "input resource creation", "t": true, "f": false, "n": null }, "relationships": { "photographer": { "data": { "type": "people", "id": "9" } } } } }');
$I->seeResponseCodeIs(201);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data.type');
$I->seeResponseJsonMatchesJsonPath('$.data.id');
$I->seeResponseJsonMatchesJsonPath('$.data.attributes');
$I->seeResponseJsonMatchesJsonPath('$.data.meta');
$I->seeResponseJsonMatchesJsonPath('$..[?(@.type == "health")]');
$I->seeResponseJsonMatchesJsonPath('$..[?(@.id == "999")]');
$I->seeResponseContains('{"title":"input resource creation","t":true,"f":false,"n":null}');
$I->seeResponseContains('{"body-length":202,"t":true,"f":false,"n":null,"foo":{"bar":"rab","baz":"zab"}}');
