<?php

$I = new ApiTester($scenario);
$I->wantTo('Resource not found');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');

$I->sendGET('/undefined');
$I->seeResponseCodeIs(404);
$I->cantSeeHttpHeader('Content-Type', 'application/vnd.api+json');

$I->sendGET('/undefined/42');
$I->seeResponseCodeIs(404);
$I->cantSeeHttpHeader('Content-Type', 'application/vnd.api+json');

$I->sendGET('/42/url/pattern-not-in-routing-rules');
$I->seeResponseCodeIs(404);
$I->cantSeeHttpHeader('Content-Type', 'application/vnd.api+json');
