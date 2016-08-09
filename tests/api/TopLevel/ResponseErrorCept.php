<?php

$I = new ApiTester($scenario);
$I->wantTo('Server must reject header');
$I->sendGET('/health');
$I->seeResponseCodeIs(406);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');
$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.errors');
$I->seeResponseJsonMatchesJsonPath('$.errors..status');
$I->seeResponseJsonMatchesJsonPath('$.errors..code');
$I->seeResponseJsonMatchesJsonPath('$.errors..title');
