<?php

declare(strict_types=1);

namespace Application\Exception\Order;

use Exception;

class OrderWithoutProductCannotBeCreatedException extends Exception
{
    protected $message = 'Order without product cannot be created';
}