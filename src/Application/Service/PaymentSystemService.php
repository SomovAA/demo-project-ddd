<?php

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
     * @return bool
     * @throws OrderPaymentFailedException
     */
    public function pay(): bool
    {
        try {
            $response = $this->client->get($this->config['payment_system']['url']);
        } catch (Exception $exception) {
            throw new OrderPaymentFailedException();
        }

        return $this->statusCodeIsOk($response->getStatusCode());
    }

    private function statusCodeIsOk(int $statusCode): bool
    {
        return $statusCode === Response::HTTP_OK;
    }
}