<?php

$I = new ApiTester($scenario);
$I->wantTo('Read resource with JsonApi response format');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendGET('/health');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->cantSeeResponseJsonMatchesJsonPath('$.errors');
$I->seeResponseJsonMatchesJsonPath('$.data.*.type');
$I->seeResponseJsonMatchesJsonPath('$.data.*.id');
$I->seeResponseJsonMatchesJsonPath('$.data.*.attributes');