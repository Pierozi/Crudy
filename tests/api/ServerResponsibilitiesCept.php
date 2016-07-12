<?php
/*
$I = new ApiTester($scenario);
$I->wantTo('Control the server responsibilities Headers');
$I->sendGET('/health');
$I->seeResponseCodeIs(200);
$I->seeResponseIsJson();
$I->seeResponseContains('{"success":"ok"}');
*/


$I = new ApiTester($scenario);
$I->wantTo('Server must reject header');
$I->sendGET('/health');
$I->seeResponseCodeIs(406);

