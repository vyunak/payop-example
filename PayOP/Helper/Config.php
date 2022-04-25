<?php

namespace PayOP\Helper;

class Config
{
    const API_URL = 'payop.com';

    const API_VERSION = '/v1';

    /**
     * @var string
     */
    private $algorithm = 'sha256';

    /**
     * @var string
     */
    private $secretKey = '';

    /**
     * @var string
     */
    public $publicKey = '';

    /**
     * @var string
     */
    public $resultUrl = '';

    /**
     * @var string
     */
    public $failPath = '';

    /**
     * @var string
     */
    public $language = 'ru';

    public function getApiUrl()
    {
        return 'https://' . self::API_URL . self::API_VERSION;
    }

    /**
     * @param string $path
     * @param string $entityId
     *
     * @return string
     */
    public function makeUrlForApi(string $path, string $entityId = ''): string
    {
        return $this->getApiUrl() . $this->getPath($path, $entityId);
    }

    /**
     * @param string $path
     * @param string $entityId
     *
     * @return string
     */
    private function getPath(string $path, string $entityId): string
    {
        return empty($entityId) ? $path : $path . '/' . $entityId;
    }

    /**
     * @return string
     */
    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     */
    public function setSecretKey(string $secretKey)
    {
        $this->secretKey = $secretKey;
    }

    /**
     * @param string $language
     */
    public function setLanguage(string $language)
    {
        $this->language = $language;
    }

    /**
     * @param string $publicKey
     */
    public function setPublicKey(string $publicKey)
    {
        $this->publicKey = $publicKey;
    }

    /**
     * @param string $resUrl
     */
    public function setResultUrl(string $resUrl)
    {
        $this->resultUrl = $resUrl;
    }

    /**
     * @param string $failPath
     */
    public function setFailPath(string $failPath)
    {
        $this->failPath = $failPath;
    }

    /**
     * @return string
     */
    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    /**
     * @param string $algorithm
     */
    public function setAlgorithm(string $algorithm)
    {
        $this->algorithm = $algorithm;
    }
}