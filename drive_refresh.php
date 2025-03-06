<?php
$clientId = "520713688292-76h72sjge0oil8sokffvjjdokp6512r1.apps.googleusercontent.com";  
$clientSecret = "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";  
$refreshToken = "1//043YaDT-b01zQCgYIARAAGAQSNwF-L9IrIjFDxrTi9-eb5AVG_Hsnz7JpCxvUeljwEIvUDo6xfSMXl6BFCxAapsTJGnzDTPBUGd0";  

$url = "https://oauth2.googleapis.com/token";

$data = [
    "client_id" => $clientId,
    "client_secret" => $clientSecret,
    "refresh_token" => $refreshToken,
    "grant_type" => "refresh_token"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

if (isset($result["access_token"])) {
    echo "New Access Token: " . $result["access_token"];
} else {
    echo "Error refreshing token: " . $response;
}
?>
