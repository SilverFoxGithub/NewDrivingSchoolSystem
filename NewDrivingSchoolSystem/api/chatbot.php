<?php
header("Content-Type: application/json");
require_once '../db/db_connect.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$api_key = getenv("DEEPSEEK_API_KEY");

if ($api_key === false) {
    error_log("DEEPSEEK_API_KEY not found in environment variables.");
    echo json_encode(["response" => "API key is missing. Check your env configuration."]);
    exit;
} else {
    error_log("DEEPSEEK_API_KEY found: " . substr($api_key, 0, 8) . "...");
}

$data = json_decode(file_get_contents("php://input"), true);
$user_message = $data['message'] ?? '';

if (!$user_message) {
    error_log("No message received from the client.");
    echo json_encode(["response" => "No message received."]);
    exit;
}

$api_url = "https://api.deepseek.com/chat"; // Use the base URL

$request_data = [
    "messages" => [
        ["role" => "user", "content" => $user_message]
    ],
    "model" => "deepseek-chat", // Specify the model
    "temperature" => 0.7,
];

$options = [
    "http" => [
        "header" => "Content-Type: application/json\r\n" .
                    "Authorization: Bearer $api_key\r\n",
        "method" => "POST",
        "content" => json_encode($request_data),
    ],
];

$context = stream_context_create($options);
$response = @file_get_contents($api_url, false, $context);

if ($response === FALSE) {
    error_log("API request failed. Check your API key or network connection.");
    echo json_encode(["response" => "API request failed. Check your API key or network connection."]);
    exit;
}

$response_data = json_decode($response, true);

if (isset($response_data['choices'][0]['message']['content'])) {
    $ai_reply = $response_data['choices'][0]['message']['content'];
    echo json_encode(["response" => $ai_reply]);
} else {
    error_log("AI service returned an unexpected response: " . print_r($response_data, true));
    echo json_encode(["response" => "AI service returned an unexpected response.", "debug" => $response_data]);
}
?>
