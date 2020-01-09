<?php

use Codeception\Util\HttpCode;

class GenerateProductsCest
{
    public function runTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->amOnPage('/api/v1/generate-products');
        $I->seeResponseCodeIs(HttpCode::OK);
    }
}
