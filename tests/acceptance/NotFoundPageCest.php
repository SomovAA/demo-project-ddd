<?php

class NotFoundPageCest
{
    public function jsonTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->amOnPage('/asdasdasdadsaads');
        $I->seePageNotFound();
    }

    public function htmlTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'text/html');
        $I->amOnPage('/asdasdasdadsaads');
        $I->seePageNotFound();
    }
}
