<?php

use PayOP\Helper\Config;
use PayOp\Helper\Payer;
use PayOp\Helper\Refund;
use PayOp\PayOp;

$config = new Config();
$config->setAlgorithm('sha256');
$config->setFailPath($_SERVER['HTTP_HOST'] . '/fail');
$config->setResultUrl($_SERVER['HTTP_HOST'] . '/result');
$config->setPublicKey('PayOp');
$config->setSecretKey('af3f2f62d929deb3968cea6b523676a35bafbb290dad3c2312fc147f150c031a');
$payOp = new PayOp($config);

//get
$getInvoiceResponse = $payOp->getInvoice('81962ed0-a65c-4d1a-851b-b3dbf9750399');

//post without Bearer
$payer = new Payer('lubim4ikvlad@gmail.com');
$makeInvoiceResponse = $payOp->makeInvoice($payer);

//post with Bearer
$reFound = new Refund('d839c714-7743-47cf-8f9d-73592597c6e1', 2, 10);
$makeInvoiceResponse = $payOp->makeRefund($reFound);