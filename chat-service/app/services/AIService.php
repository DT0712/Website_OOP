<?php
class AIService {

    public static function ask($history, $userMessage) {

        $config = require __DIR__ . '/../config/config.php';
        $apiKey = $config['openai_key'];

        // build messages từ history
        $messages = [
            [
                "role"=>"system",
                "content"=>"Bạn là nhân viên tư vấn bán xe đạp thể thao cho BikeMarket. Trả lời ngắn gọn, thân thiện."
            ]
        ];

        foreach($history as $msg){
            $messages[] = [
                "role" => $msg['sender']=="user" ? "user" : "assistant",
                "content" => $msg['message']
            ];
        }

        $messages[] = ["role"=>"user","content"=>$userMessage];

        $data = [
            "model" => "gpt-4o-mini",
            "messages" => $messages
        ];

        $ch = curl_init("https://api.openai.com/v1/chat/completions");

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer ".$apiKey
            ],
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);

        return $response['choices'][0]['message']['content'] 
            ?? "AI lỗi 😢";
    }
}