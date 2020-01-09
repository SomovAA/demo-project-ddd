<?php

use Codeception\Util\HttpCode;

class PayOrderCest
{
    public function withoutParamsTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->sendAjaxPostRequest('/api/v1/order/pay');
        $I->seeResponseCodeIs(HttpCode::CONFLICT);
    }

    public function requestGetTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->amOnPage('/api/v1/order/pay');
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
    }

    public function trashParamsTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->sendAjaxPostRequest('/api/v1/order/pay', ['productIds' => ['trash']]);
        $I->seeResponseCodeIs(HttpCode::CONFLICT);
    }
}
