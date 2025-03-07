<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
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
file_put_contents('webhook_log.txt', $input . PHP_EOL, FILE_APPEND);


echo "Webhook is set up!";
?>
