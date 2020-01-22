<?php

declare(strict_types=1);

namespace Application\Exception\Order;

use Exception;

class OrderSuchProductsDoNotExistException extends Exception
{
    protected $message = 'Such products do not exist. Order cannot be created';
}