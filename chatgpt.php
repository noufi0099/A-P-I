<?php
// Replace with your OpenAI API key
$api_key = "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";

header("Access-Control-Allow-Origin: *"); // Allow requests from any origin
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Get user input
$request = json_decode(file_get_contents("php://input"), true);
$user_message = isset($request["message"]) ? trim($request["message"]) : "";

if (!$user_message) {
    echo json_encode(["error" => "Message cannot be empty."]);
    exit;
}

// Prepare API request payload
$data = [
    "model" => "gpt-4o",
    "messages" => [
        ["role" => "system", "content" => "You are a helpful assistant."],
        ["role" => "user", "content" => $user_message]
    ]
];

// Initialize cURL
$ch = curl_init("https://api.openai.com/v1/chat/completions");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $api_key",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

$response = curl_exec($ch);
$http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// Debugging: Print Full Response
echo json_encode([
    "status" => $http_status,
    "response" => json_decode($response, true)
]);
?>
