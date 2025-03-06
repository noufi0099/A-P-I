<?php
$accessToken = "ya29.a0AeXRPp6xGuAJI_RS0ot5-bnZmxq9sGLvck82qlx4hlvwYgwEW-7h1CrVuEerNX5qsuA3I5agezQaNFi8I-sxPWcZckUzsEZjg1UL8Zl442l1emo-0CqOUdPqz9_ekRlmcGYJ1f8Y2pDsIqxaXgx_7fX23ajUwmn0cWI3MDsSaCgYKAW4SARASFQHGX2MijlSA6w0WyxravAq82bCyjQ0175";
$filePath = "F:\s1.pdf"; 
$fileName = basename($filePath);

$metadata = [
    'name' => $fileName, 
    'parents' => ['root'] 
];

$boundary = uniqid();
$eol = "\r\n";
$body = "--$boundary$eol";
$body .= "Content-Type: application/json; charset=UTF-8$eol$eol";
$body .= json_encode($metadata) . $eol;
$body .= "--$boundary$eol";
$body .= "Content-Type: application/octet-stream$eol$eol";
$body .= file_get_contents($filePath) . $eol;
$body .= "--$boundary--$eol";

$url = "https://www.googleapis.com/upload/drive/v3/files?uploadType=multipart";
$headers = [
    "Authorization: Bearer $accessToken",
    "Content-Type: multipart/related; boundary=$boundary",
    "Content-Length: " . strlen($body)
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
curl_close($ch);

echo "Response: " . $response;
?>


