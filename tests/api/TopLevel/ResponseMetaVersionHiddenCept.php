<?php

$I = new ApiTester($scenario);
$I->wantTo('Check TopLevel meta not present');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendGET('/meta/123');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->cantSeeResponseJsonMatchesJsonPath('$.meta');
