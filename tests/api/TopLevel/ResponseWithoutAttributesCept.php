<?php

$I = new ApiTester($scenario);
$I->wantTo('Read existing resource without attributes');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendGET('/data-without-attribute/42');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data.type');
$I->seeResponseJsonMatchesJsonPath('$.data.id');
$I->seeResponseContains('"attributes":null');
