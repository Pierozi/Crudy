<?php

$I = new ApiTester($scenario);
$I->wantTo('Update resource');
$I->haveHttpHeader('ACCEPT', 'application/vnd.api+json');
$I->haveHttpHeader('Content-Type', 'application/vnd.api+json');

$data = json_encode([
    'data' => [
        'type' => 'articles',
        'attributes' => [
            'foo' => 'bar',
            'baz' => true,
        ],
    ],
]);

$I->sendPATCH('/articles/42', $data);
$I->seeResponseCodeIs(200);
$I->seeHttpHeader('Content-Type', 'application/vnd.api+json');

$I->seeResponseIsJson();
$I->seeResponseJsonMatchesJsonPath('$.data.type');
$I->seeResponseJsonMatchesJsonPath('$.data.id');
$I->seeResponseJsonMatchesJsonPath('$.data.attributes');
$I->seeResponseJsonMatchesJsonPath('$..[?(@.id == "42")]');
$I->seeResponseJsonMatchesJsonPath('$..[?(@.type == "articles")]');
$I->seeResponseContains('{"foo":"bar","baz":true}');
