Refresh Access Token

<?php
define("APP_ID", "616236781197610");
define("APP_SECRET", "00917f71e724f925e8da9782718e6e5c"); //developer console->app settings->basic
define("PAGE_ID", "612156968640108");  //meta business suite->settings->pages

$accessToken = "YOUR_CURRENT_PAGE_ACCESS_TOKEN";

function isTokenValid($token) {
    $url = "https://graph.facebook.com/debug_token?"
        . "input_token=" . $token
        . "&access_token=" . APP_ID . "|" . APP_SECRET;

    $response = makeCurlRequest($url);
    return isset($response['data']['is_valid']) && $response['data']['is_valid'];
}

function getLongLivedPageToken() {
    $url = "https://graph.facebook.com/v19.0/" . PAGE_ID . "?fields=access_token&access_token=" . APP_ID . "|" . APP_SECRET;

    return makeCurlRequest($url);
}

function makeCurlRequest($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

if (!isTokenValid($accessToken)) {
    echo "Token Expired! Refreshing...\n";

    $pageTokenResponse = getLongLivedPageToken();
    if (!isset($pageTokenResponse['access_token'])) {
        die("Failed to get a new page token!");
    }
    $accessToken = $pageTokenResponse['access_token'];
    
    echo "New Page Access Token: " . $accessToken . "\n";
} else {
    echo "Token is valid: " . $accessToken . "\n";
}


