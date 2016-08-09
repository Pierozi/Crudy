<?php

$I = new ApiTester($scenario);
$I->wantTo('Create new resource with no content result');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->haveHttpHeader('Content-Type', 'application/vnd.api+json');

$id = \Hoa\Consistency\Consistency::uuid();

$data = json_encode([
    'data' => [
        'id' => $id,
        'type' => 'articles',
        'attributes' => [
            'nocontent' => true,
        ],
    ],
]);

$I->sendPOST('/articles', $data);
$I->seeResponseCodeIs(204);
