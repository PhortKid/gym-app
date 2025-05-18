<?php

namespace App\Services;

class BalanceService
{
    private $apiKey;
    private $secretKey;
    private $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('BEEM_API_KEY');
        $this->secretKey = env('BEEM_SECRET_KEY');
        $this->apiUrl = 'https://apisms.beem.africa/public/v1/vendors/balance';
    }

    public function checkBalance()
    {
        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($ch, [
            CURLOPT_HTTPGET => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization:Basic ' . base64_encode("{$this->apiKey}:{$this->secretKey}"),
                'Content-Type: application/json',
            ],
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($response === false) {
            return [
                'success' => false,
                'error' => curl_error($ch),
            ];
        }

        $result = json_decode($response, true);

        if ($httpCode == 200 && isset($result['data']['credit_balance'])) {
            return [
                'success' => true,
                'credit_balance' => $result['data']['credit_balance'],
            ];
        } elseif (isset($result['message'])) {
            return [
                'success' => false,
                'error' => $result['message'],
            ];
        } else {
            return [
                'success' => false,
                'error' => 'Unable to fetch balance. Unexpected response.',
            ];
        }
    }
}
