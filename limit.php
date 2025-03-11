<?php
$api_key = "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";

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
