<?php

use Codeception\Util\HttpCode;

class ApiHomeCest
{
    public function successTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->amOnPage('/api');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->canSee('API');
    }
}
