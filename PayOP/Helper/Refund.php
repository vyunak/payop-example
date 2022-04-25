<?php

namespace PayOp\Helper;

class Refund
{
    private $transactionIdentifier;
    private $refundType;
    private $amount;
    private $metadata;

    public function __construct($transactionIdentifier, $refundType, $amount, $metadata = [])
    {
        $this->transactionIdentifier = $transactionIdentifier;
        $this->refundType = $refundType;
        $this->amount = $amount;
        $this->metadata = $metadata;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return [
            'transactionIdentifier' => $this->transactionIdentifier,
            'refundType' => $this->refundType,
            'amount' => $this->amount,
            'metadata' => $this->metadata,
        ];
    }

}