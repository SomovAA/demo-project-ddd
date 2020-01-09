<?php

namespace Application\Exception\Order;

use Exception;

class OrderNotNewException extends Exception
{
    protected $message = 'Order not new';
}