<?php

$I = new ApiTester($scenario);
$I->wantTo('Try create new resource unauthorized access');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->haveHttpHeader('Content-Type', 'application/vnd.api+json');

$data = json_encode([
    'data' => [
        'type' => 'articles',
        'attributes' => [
            'forbidden' => true,
        ],
    ],
]);

$I->sendPOST('/articles', $data);
$I->seeResponseCodeIs(403);
