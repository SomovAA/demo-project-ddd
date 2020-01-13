<?php

namespace Application\Exception\Order;

use Exception;

class OrderIsAlreadyPaidException extends Exception
{
    protected $message = 'Order is already paid';
}