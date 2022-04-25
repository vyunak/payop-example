<?php

namespace PayOp;

use PayOP\Helper\Config;
use PayOp\Helper\Payer;
use PayOp\Helper\Refund;
use PayOP\Helper\Signature;
use PayOp\HttpClient\HttpCurl;
use PayOp\HttpClient\Response;
use RuntimeException;

class PayOp
{

    /**
     * @var Config
     */
    private $config;
    /**
     * @var HttpCurl
     */
    private $client;
    /**
     * @var Signature
     */
    private $signature;

    /**
     * @param Config $configuration
     */
    public function __construct(Config $configuration)
    {
        $this->config = $configuration;

        $this->client = new HttpCurl();
        $this->signature = new Signature();
    }

    public function makeRefund(Refund $data)
    {
        return $this->post($this->config->makeUrlForApi('/refunds/create'), $data->getData(), '', $this->getAuthorizationHeader());
    }

    /**
     * @param Payer $payer
     * @return Response
     */
    public function makeInvoice(Payer $payer): Response
    {
        // Я не стал описывать Response класс, так как это зайдем достаточно много времени.
        $dataSign = [
            'id' => 'FF01',
            'amount' => '100.0000',
            'currency' => 'USD'
        ];
        $signature = $this->signature->makeSignature($dataSign, $this->config->getSecretKey(), $this->config->getAlgorithm());
        $data = [
            'publicKey' => $this->config->publicKey,
            'order' => $dataSign,
            'payer' => $payer->getData(),
            'language' => $this->config->language,
            'resultUrl' => $this->config->resultUrl,
            'failPath' => $this->config->failPath,
            'signature' => $signature
        ];
        return $this->post($this->config->makeUrlForApi('/invoices/create'), $data, $signature);
    }

    public function getInvoice($invoiceId)
    {
        return $this->get($this->config->makeUrlForApi('/invoices', $invoiceId));
    }


    /**
     * @param string $url
     * @param array  $headers
     * @param array  $data
     *
     * @throws RuntimeException
     *
     * @return Response
     */
    private function get(string $url, array $headers = [], array $data = []): Response
    {
        $requestParams = count($data) == 0 ? '' : '?' . http_build_query($data);

        return $this->client->request('GET', $url . $requestParams, $headers, $data);
    }

    /**
     * @param string $url
     * @param array $data
     * @param string $signature
     * @param array $headers
     * @return Response
     */
    private function post(string $url, array $data = [], $signature = '', array $headers = []): Response
    {
        if (!empty($signature)) {
            $data['signature'] = $signature;
        }
        return $this->client->request('POST', $url, $headers, $data);
    }

    /**
     * @return array
     */
    private function getAuthorizationHeader(): array
    {
        return ['Authorization: Bearer ' . hash('sha256', uniqid())];
    }
}