<?php

$I = new ApiTester($scenario);
$I->wantTo('Server must accept header');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendGET('/health');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
