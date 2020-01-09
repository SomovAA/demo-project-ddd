<?php

use Codeception\Util\HttpCode;

class HomeCest
{
    public function runTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->amOnPage('/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->canSee('Hello');
    }
}
