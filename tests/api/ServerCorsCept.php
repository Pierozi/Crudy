<?php

$I = new ApiTester($scenario);
$I->wantTo('Server must handle CORS request');
$I->haveHttpHeader('Access-Control-Request-Method', 'ALL');
$I->haveHttpHeader('Access-Control-Request-Headers', 'ALL');
$I->sendOPTIONS('/health');
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Access-Control-Allow-Headers', 'origin, accept, content-type, authorization');
$I->seeHttpHeader('Access-Control-Allow-Credentials', 'true');
$I->seeHttpHeader('Access-Control-Expose-Headers', 'set');
$I->seeHttpHeader('Access-Control-Allow-Origin', 'http://localhost:8080');
$I->seeHttpHeader('Access-Control-Allow-Methods', 'POST, GET, PATCH, DELETE, PUT, HEAD');
