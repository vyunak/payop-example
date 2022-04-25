<?php

namespace PayOP\Helper;

class Signature
{
    /**
     * @param array  $data
     * @param string $key
     * @param string $algorithm
     *
     * @return string
     */
    public static function makeSignature(array $data, string $key, $algorithm = 'sha256'): string
    {
        ksort($data, SORT_STRING);
        $data = array_values(array_filter($data));
        $data[] = $key;
        return hash($algorithm, implode(':', $data));
    }

    /**
     * @param string $signatureRequest
     * @param array $data
     * @param string $key
     * @param string $algorithm
     *
     * @return bool
     */
    public static function checkSignature(string $signatureRequest, array $data, string $key, $algorithm = 'sha256'): bool
    {
        $signature = self::makeSignature(array_filter($data), $key, $algorithm);

        return $signatureRequest === $signature;
    }
}