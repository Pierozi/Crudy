<?php

$I = new ApiTester($scenario);
$I->wantTo('Get specific articles resource');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendGET('/articles/42');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');

$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data.type');
$I->seeResponseJsonMatchesJsonPath('$.data.id');
$I->seeResponseJsonMatchesJsonPath('$.data.attributes');
$I->seeResponseJsonMatchesJsonPath('$..[?(@.type == "articles")]');
$I->seeResponseContains('{"foo":"bar","baz":true}');
