Refresh Page Access Token 

<?php

define("APP_ID", "616236781197610");
define("APP_SECRET", "00917f71e724f925e8da9782718e6e5c");
define("PAGE_ID", "612156968640108");

function getShortLivedToken() {
    $url = "https://graph.facebook.com/v22.0/oauth/access_token?" .
           "client_id=" . APP_ID .
           "&client_secret=" . APP_SECRET .
           "&grant_type=client_credentials";

    return makeCurlRequest($url);
}

function getLongLivedToken($shortLivedToken) {
    $url = "https://graph.facebook.com/v22.0/oauth/access_token?" .
           "grant_type=fb_exchange_token" .
           "&client_id=" . APP_ID .
           "&client_secret=" . APP_SECRET .
           "&fb_exchange_token=" . $shortLivedToken;

    return makeCurlRequest($url);
}

function getPageAccessToken($longLivedUserToken) {
    $url = "https://graph.facebook.com/v22.0/" . PAGE_ID .
           "?fields=access_token&access_token=" . $longLivedUserToken;

    return makeCurlRequest($url);
}

function makeCurlRequest($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

$shortLivedToken = getShortLivedToken();

$longLivedUserToken = getLongLivedToken($shortLivedToken['access_token']);

$pageAccessToken = getPageAccessToken($longLivedUserToken['access_token']);

echo "Page Access Token: " . $pageAccessToken['access_token'];

?>
