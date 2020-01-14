<?php

use Codeception\Util\HttpCode;

class ProductCest
{
    public function generateProductsTest(AcceptanceTester $I)
    {
        $I->setHeader('Content-Type', 'application/json');
        $I->sendAjaxPostRequest('/api/v1/products/generate');
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }
}
