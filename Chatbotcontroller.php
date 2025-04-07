<?php

namespace YourName\Chatbot;

use Psr\Http\Message\ServerRequestInterface as Request;
use Zend\Diactoros\Response\JsonResponse;

class ChatbotController
{
    public function handle(Request $request)
    {
        $input = $request->getParsedBody()['message'] ?? '';

        // Kirim permintaan ke API Chatbot (contoh menggunakan OpenAI)
        $response = $this->sendToChatbotAPI($input);

        return new JsonResponse(['reply' => $response]);
    }

    private function sendToChatbotAPI($message)
    {
        $apiKey = 'YOUR_API_KEY';
        $url = 'https://api.openai.com/v1/chat/completions';

        $data = [
            'model' => 'gpt-4',
            'messages' => [
                ['role' => 'user', 'content' => $message]
            ]
        ];

        $options = [
            'http' => [
                'header'  => "Content-Type: application/json\r\nAuthorization: Bearer $apiKey\r\n",
                'method'  => 'POST',
                'content' => json_encode($data),
            ],
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            "Content-Type: application/json",
            "Authorization: Bearer $apiKey"
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $result = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return 'Error connecting to Chatbot API: ' . curl_error($ch);
        }

        curl_close($ch);

        $response = json_decode($result, true);
        return $response['choices'][0]['message']['content'] ?? 'No response.';
    }
}
?>