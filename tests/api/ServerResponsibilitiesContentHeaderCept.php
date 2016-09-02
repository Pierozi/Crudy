<?php


$I = new ApiTester($scenario);
$I->wantTo('Create resource request without content-type throw 415 err code');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->sendPOST('/articles', ['foo' => true]);
$I->seeResponseCodeIs(415);

$I->sendPATCH('/articles/1', ['foo' => true]);
$I->seeResponseCodeIs(415);
