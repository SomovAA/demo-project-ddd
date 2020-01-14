<?php

use Codeception\Util\HttpCode;

class HomeCest
{
    public function successTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'text/html');
        $I->amOnPage('/');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->canSee('Hello');
    }
}
