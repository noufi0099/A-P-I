<?php
$accessToken = "ya29.a0AeXRPp7WKEXIDicMrIpMZ0MZG2LnM9MAUcvR82fXx-gCetP2sfReDpTaslwzSiTObV_PjOdDZjFYA_Edy1625WOWoZ79vL32ruGIFCxRAZbEiqSBpYzwQY-ePvUOL0wlnQ42kKczpt8aCQJ3ErVgy8feYD55bXGp8fjF91_QaCgYKAfMSARASFQHGX2MiqPuZUj-nY9_ZMiOuySbQDQ0175"; 
$fileName = "sample.pdf";

$searchUrl = "https://www.googleapis.com/drive/v3/files?q=name='" . urlencode($fileName) . "'&fields=files(id,name)";

$headers = [
    "Authorization: Bearer $accessToken"
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $searchUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
curl_close($ch);

$data = json_decode($response, true);

if (empty($data['files'])) {
    die("File '$fileName' not found on Google Drive.");
}

$fileId = $data['files'][0]['id']; 

$deleteUrl = "https://www.googleapis.com/drive/v3/files/$fileId";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $deleteUrl);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($httpCode == 204) {
    echo "File '$fileName' deleted successfully.";
} else {
    echo "Failed to delete file. HTTP Code: $httpCode";
}
?>
