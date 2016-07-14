<?php

$I = new ApiTester($scenario);
$I->wantTo('Data result must be object in read specific resource case');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendGET('/data-single/42');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data.type');
$I->seeResponseJsonMatchesJsonPath('$.data.id');
$I->seeResponseJsonMatchesJsonPath('$.data.attributes.foo');
$I->seeResponseJsonMatchesJsonPath('$.data.attributes.baz');

$I->sendGET('/data-single');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data..type');
$I->seeResponseJsonMatchesJsonPath('$.data..id');
$I->seeResponseJsonMatchesJsonPath('$.data..attributes.foo');
$I->seeResponseJsonMatchesJsonPath('$.data..attributes.baz');
$I->seeResponseJsonArrayCountEqual('$.data', 1);
