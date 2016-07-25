<?php

$I = new ApiTester($scenario);
$I->wantTo('Request send with header must be accessible in resource');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->haveHttpHeader('X-BEHAT', 'false');
$I->haveHttpHeader('X-Authorization', '38ba1168e64cae1836d628528aaa1d030d39628640a48c65');
$I->haveHttpHeader('X-CRUDY-TU', 'codeception');
$I->haveHttpHeader('X-is-test', 'TRUE');
$I->haveHttpHeader('User-Agent', 'codeception');
$I->sendGET('/data-header/1');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data.type');
$I->seeResponseJsonMatchesJsonPath('$.data.id');
$I->seeResponseJsonMatchesJsonPath('$.data.attributes.headers');
$I->seeResponseJsonMatchesJsonPath('$.data.attributes.equal');
$I->seeResponseContains('"equal":true');
$I->seeResponseContains('"X-BEHAT":false');
$I->seeResponseContains('"X-IS-TEST":true');
$I->seeResponseContains('"X-AUTHORIZATION":"38ba1168e64cae1836d628528aaa1d030d39628640a48c65"');
$I->seeResponseContains('"X-CRUDY-TU":"codeception"');
$I->seeResponseContains('"USER-AGENT":"codeception"');
