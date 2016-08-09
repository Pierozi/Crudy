<?php


$I = new ApiTester($scenario);
$I->wantTo('Create resource request without content-type throw 415 err code');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendPOST('/undefined');
$I->seeResponseCodeIs(415);

$I->sendPUT('/undefined');
$I->seeResponseCodeIs(415);
