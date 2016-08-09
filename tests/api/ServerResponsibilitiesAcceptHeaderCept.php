<?php

$I = new ApiTester($scenario);
$I->wantTo('Server must reject header');
$I->sendGET('/health');
$I->seeResponseCodeIs(406);
