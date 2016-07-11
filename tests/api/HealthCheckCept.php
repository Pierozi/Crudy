<?php 
$I = new ApiTester($scenario);
$I->wantTo('test the HealthCheck resource');
$I->sendGET('/health');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('{"success":"ok"}');

