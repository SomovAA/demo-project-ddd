<?php

declare(strict_types=1);

namespace Application\Service;

use Application\Exception\Order\OrderPaymentFailedException;
use Exception;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Response;

class PaymentSystemService
{
    private $client;
    private $config;

    public function __construct(Client $client, array $config)
    {
        $this->client = $client;
        $this->config = $config;
    }

    /**
     * @return void
     * @throws OrderPaymentFailedException
     */
    public function pay(): void
    {
        try {
            $response = $this->client->get($this->config['payment_system']['url']);
        } catch (Exception $exception) {
            throw new OrderPaymentFailedException();
        }

        if (!$this->statusCodeIsOk($response->getStatusCode())) {
            throw new OrderPaymentFailedException();
        }
    }

    private function statusCodeIsOk(int $statusCode): bool
    {
        return $statusCode === Response::HTTP_OK;
    }
}