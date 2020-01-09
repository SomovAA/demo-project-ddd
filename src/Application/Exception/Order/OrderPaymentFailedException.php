<?php

namespace Application\Exception\Order;

use Exception;

class OrderPaymentFailedException extends Exception
{
    protected $message = 'Order payment failed';
}