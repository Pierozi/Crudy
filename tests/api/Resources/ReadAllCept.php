<?php

$I = new ApiTester($scenario);
$I->wantTo('Get specific articles resource');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendGET('/articles');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');

$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data[0]type');
$I->seeResponseJsonMatchesJsonPath('$.data[0]id');
$I->seeResponseJsonMatchesJsonPath('$.data[0]attributes');
$I->seeResponseJsonMatchesJsonPath('$.data[?(@.type == "articles")]');
