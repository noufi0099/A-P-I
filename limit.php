<?php
$api_key = "open api key";

// Get today's date (YYYY-MM-DD)
$date = date("Y-m-d");

$ch = curl_init("https://api.openai.com/v1/usage?date=$date");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $api_key",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

echo "<pre>";
print_r(json_decode($response, true));
echo "</pre>";
?>
