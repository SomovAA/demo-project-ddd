<?php

class NotFoundPageCest
{
    public function runTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->amOnPage('/asdasdasdadsaads');
        $I->seePageNotFound();
    }
}
