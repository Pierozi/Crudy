<?php

$I = new ApiTester($scenario);
$I->wantTo('Check TopLevel meta object');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendGET('/meta');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.meta');
