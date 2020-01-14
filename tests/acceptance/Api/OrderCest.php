<?php

use Codeception\Util\HttpCode;

class OrderCest
{
    public function listTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->amOnPage('/api/v1/orders');
        $I->seeResponseCodeIs(HttpCode::OK);
    }

    public function createWithoutParamsTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->sendAjaxPostRequest('/api/v1/orders');
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    public function createWithNotValidParamsTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->sendAjaxPostRequest('/api/v1/orders', ['orderId' => 'trash', 'price' => 'trash']);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    public function payWithoutParamsTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->sendAjaxPostRequest('/api/v1/orders/pay');
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    public function payRequestGetTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->amOnPage('/api/v1/orders/pay');
        $I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
    }

    public function payTrashParamsTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->sendAjaxPostRequest('/api/v1/orders/pay', ['productIds' => ['trash']]);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }
}
