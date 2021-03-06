<?php

declare(strict_types=1);

namespace Application\Exception\Order;

use Exception;

class OrderPriceDoesNotMatchException extends Exception
{
    protected $message = 'Order price does not match';
}