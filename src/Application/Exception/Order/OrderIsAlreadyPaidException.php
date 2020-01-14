<?php

declare(strict_types=1);

namespace Application\Exception\Order;

use Exception;

class OrderIsAlreadyPaidException extends Exception
{
    protected $message = 'Order is already paid';
}