<?php

$I = new ApiTester($scenario);
$I->wantTo('Check TopLevel custom meta object');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->haveHttpHeader('Content-Type', 'application/vnd.api+json');
$I->sendPOST('/meta');
$I->seeResponseCodeIs(201);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.meta');
$I->seeResponseEquals('{"data":[],"meta":{"copyright":"Copyright 2015 Example Corp.","authors":["Yehuda Katz","Steve Klabnik","Dan Gebhardt","Tyler Kellen"]}}');
