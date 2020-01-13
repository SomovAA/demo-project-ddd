<?php

namespace Application\Exception\Order;

use Exception;

class OrderIsAlreadyNewException extends Exception
{
    protected $message = 'Order is already new';
}