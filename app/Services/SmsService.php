<?php

namespace App\Services;

class SmsService
{
    private $apiKey;
    private $secretKey;
    private $senderId;
    private $apiUrl;

    public function __construct()
    {
        $this->apiKey = env('BEEM_API_KEY');
        $this->secretKey = env('BEEM_SECRET_KEY');
        $this->senderId = env('BEEM_SENDER_ID');
        $this->apiUrl = 'https://apisms.beem.africa/v1/send';
    }

    public function sendSms($message, $recipients)
    {
        $postData = [
            'source_addr' => $this->senderId,
            'encoding' => 0,
            'schedule_time' => '',
            'message' => $message,
            'recipients' => [],
        ];

        foreach ($recipients as $key => $number) {
            $cleanedNumber = ltrim($number, '+'); // Ondoa "+" kama ipo
            $postData['recipients'][] = [
                'recipient_id' => $key + 1,
                'dest_addr' => $cleanedNumber
            ];
        }

        $ch = curl_init($this->apiUrl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Authorization:Basic ' . base64_encode("$this->apiKey:$this->secretKey"),
                'Content-Type: application/json'
            ],
            CURLOPT_POSTFIELDS => json_encode($postData)
        ]);

        $response = curl_exec($ch);

        if ($response === false) {
            return [
                'success' => false,
                'error' => curl_error($ch),
            ];
        }

        $result = json_decode($response, true);

        if (isset($result['successful']) && $result['successful'] === true) {
            return [
                'success' => true,
                'request_id' => $result['request_id'],
                'message' => $result['message']
            ];
        } else {
            return [
                'success' => false,
                'error' => $result['message'] ?? 'Unknown error'
            ];
        }
    }
}
