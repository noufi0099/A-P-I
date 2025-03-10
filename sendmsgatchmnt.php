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

if (isset($data['entry'][0]['messaging'])) {
    foreach ($data['entry'][0]['messaging'] as $event) {
        if (isset($event['message'])) {
            $senderId = $event['sender']['id'];

            if (isset($event['message']['text'])) {
                $messageText = $event['message']['text'];
                $logMessage = "Message received from User ID: $senderId\nMessage: $messageText\n\n";
                file_put_contents('webhook_log.txt', $logMessage, FILE_APPEND);
            }

            if (isset($event['message']['attachments'])) {
                foreach ($event['message']['attachments'] as $attachment) {
                    if (isset($attachment['payload']['url'])) {
                        $attachmentUrl = $attachment['payload']['url'];
                        $fileExtension = pathinfo(parse_url($attachmentUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                        $fileName = "attachments/" . uniqid("attachment_") . "." . $fileExtension;

                        // Ensure the attachments directory exists
                        if (!is_dir("attachments")) {
                            mkdir("attachments", 0777, true);
                        }

                        // Download and save the attachment
                        $fileContent = file_get_contents($attachmentUrl);
                        file_put_contents($fileName, $fileContent);

                        $logMessage = "Attachment received from User ID: $senderId\nURL: $attachmentUrl\nSaved as: $fileName\n\n";
                        file_put_contents('webhook_log.txt', $logMessage, FILE_APPEND);
                    }
                }
            }
        }
    }
}

echo "Webhook received!";
?>


