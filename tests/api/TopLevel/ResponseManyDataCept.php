<?php

$I = new ApiTester($scenario);
$I->wantTo('Data result must be object in read specific resource case');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendGET('/data-many');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data..type');
$I->seeResponseJsonMatchesJsonPath('$.data..id');
$I->seeResponseJsonMatchesJsonPath('$.data.0.attributes.foo');
$I->seeResponseJsonMatchesJsonPath('$.data.0.attributes.baz');
$I->seeResponseJsonMatchesJsonPath('$.data.1.attributes.foo2');
$I->seeResponseJsonMatchesJsonPath('$.data.1.attributes.baz2');
$I->seeResponseJsonArrayCountEqual('$.data', 2);
