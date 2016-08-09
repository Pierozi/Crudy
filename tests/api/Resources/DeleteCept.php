<?php

$I = new ApiTester($scenario);
$I->wantTo('Delete resource');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->haveHttpHeader('Content-Type', 'application/vnd.api+json');

$data = json_encode([
    'data' => [
        'type' => 'articles',
        'attributes' => [
            'isDelete' => true,
        ],
    ],
]);

$I->sendDELETE('/articles/42', $data);
$I->seeResponseCodeIs(204);
