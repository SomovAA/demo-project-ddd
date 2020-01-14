<?php

use Codeception\Exception\ConditionalAssertionFailed;
use Codeception\Util\HttpCode;

class PaymentSystemServiceCest
{
    public function availableTest(AcceptanceTester $I)
    {
        try {
            $I->amOnPage('http://ya.ru');
            $I->seeResponseCodeIs(HttpCode::OK);
        } catch (Exception $exception) {
            throw new ConditionalAssertionFailed($exception->getMessage());
        }
    }

    public function notAvailableTest(AcceptanceTester $I)
    {
        try {
            $I->amOnPage('http://ya');
        } catch (Exception $exception) {
            $I->comment($exception->getMessage());

            return true;
        }

        throw new ConditionalAssertionFailed('without errors');
    }
}
