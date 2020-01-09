<?php

use Codeception\Util\HttpCode;

class CreateOrderCest
{
    public function withoutParamsTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->sendAjaxPostRequest('/api/v1/order/create');
        $I->seeResponseCodeIs(HttpCode::CONFLICT);
    }

    public function requestGetTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->amOnPage('/api/v1/order/create');
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
    }

    public function trashParamsTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->sendAjaxPostRequest('/api/v1/order/create', ['orderId' => 'trash', 'price' => 'trash']);
        $I->seeResponseCodeIs(HttpCode::CONFLICT);
    }
}
