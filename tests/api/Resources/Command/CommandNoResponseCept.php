<?php

$I = new ApiTester($scenario);
$I->wantTo('Call command on specific resource');
$I->haveHttpHeader('Content-Type', 'application/vnd.api+json');
$I->haveHttpHeader('Accept', 'application/vnd.api+json');

$data = json_encode([
    'data' => [
        'topic' => 'foo.bar',
    ],
]);

$I->sendPOST('/articles/42/command/subscribe', $data);
$I->seeResponseCodeIs(204);
