<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$VERIFY_TOKEN = "mytestmsg";

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['hub_verify_token'])) {
    if ($_GET['hub_verify_token'] === $VERIFY_TOKEN) {
        echo $_GET['hub_challenge'];
        exit;
    } else {
        http_response_code(403);
        echo "Invalid verify token";
        exit;
    }
}

$input = file_get_contents("php://input");

$data = json_decode($input, true);

// file_put_contents('webhook_log.txt', "Webhook triggered at " . date('Y-m-d H:i:s') . "\nRAW DATA: " . print_r($data, true) . "\n\n", FILE_APPEND);

if (isset($data['entry'][0]['messaging'])) {
    foreach ($data['entry'][0]['messaging'] as $event) {
        if (isset($event['message'])) {
            $senderId = $event['sender']['id'];
            $messageText = $event['message']['text'] ?? '';

            $logMessage = "Message received from User ID: $senderId\nMessage: $messageText\n\n";
            file_put_contents('webhook_log.txt', $logMessage, FILE_APPEND);
        }
    }
}

echo "Webhook received!";
?>
