<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$VERIFY_TOKEN = "mytestmsg";  

// Facebook Webhook Verification
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

// Read incoming JSON data
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Debugging: Log raw data temporarily
file_put_contents('webhook_log.txt', "RAW DATA:\n" . print_r($data, true) . "\n\n", FILE_APPEND);

// Ensure "entry" key exists
if (isset($data['entry']) && is_array($data['entry'])) {
    foreach ($data['entry'] as $entry) {
        if (isset($entry['messaging']) && is_array($entry['messaging'])) {
            foreach ($entry['messaging'] as $event) {
                if (isset($event['sender']['id'])) {
                    $senderId = $event['sender']['id'];

                    // If text message is received
                    if (isset($event['message']['text'])) {
                        $messageText = $event['message']['text'];
                        $logMessage = "User ID: $senderId\nMessage: $messageText\n\n";
                        file_put_contents('webhook_log.txt', $logMessage, FILE_APPEND);
                    }

                    // If attachment is received
                    if (isset($event['message']['attachments'])) {
                        foreach ($event['message']['attachments'] as $attachment) {
                            if (isset($attachment['payload']['url'])) {
                                $attachmentUrl = $attachment['payload']['url'];

                                // Log only attachment URL
                                file_put_contents('webhook_log.txt', "User ID: $senderId\nAttachment URL: $attachmentUrl\n\n", FILE_APPEND);

                                // Get file extension (default to .jpg if not found)
                                $fileExtension = pathinfo(parse_url($attachmentUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
                                if (!$fileExtension) {
                                    $fileExtension = "jpg";
                                }

                                // Create filename & ensure attachments directory exists
                                $fileName = "attachments/" . uniqid("attachment_") . "." . $fileExtension;
                                if (!is_dir("attachments")) {
                                    mkdir("attachments", 0777, true);
                                }

                                // Download the file
                                $fileContent = file_get_contents($attachmentUrl);
                                if ($fileContent !== false) {
                                    file_put_contents($fileName, $fileContent);
                                    file_put_contents('webhook_log.txt', "Saved attachment: $fileName\n\n", FILE_APPEND);
                                } else {
                                    file_put_contents('webhook_log.txt', "Failed to download: $attachmentUrl\n\n", FILE_APPEND);
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}

echo "Webhook received!";
?>

