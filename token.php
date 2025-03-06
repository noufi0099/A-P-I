To get long lived access token by exchanging short lived Access token

<?php
define("APP_ID", "616236781197610");
define("APP_SECRET", "00917f71e724f925e8da9782718e6e5c");
define("PAGE_ID", "612156968640108");
define("SHORT_LIVED_USER_TOKEN", "EAAIwds5w2SoBO2PKQUjUrfpMlm4tY6osVLxQDnx0GwZCD9jrC2WPynCBW7f1pD0bHlG2yZCDPIf5vIK0a2SJqxGblI2hT4Xdc17K2uAoETEcSLxX4usIO0dZBXxxNLkEVPrCKGSN5KxxA6LxfjT99c2T0f9xSgsOf8HEthgzEbJ6XRbIP5ih1UOSIkWBpO6ZANdA3ch3CY1eRYZAzblZCICMsDIDS3IePniqgZD");

function makeCurlRequest($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

function getLongLivedUserToken() {
    $url = "https://graph.facebook.com/v19.0/oauth/access_token?"
        . "grant_type=fb_exchange_token"
        . "&client_id=" . APP_ID
        . "&client_secret=" . APP_SECRET
        . "&fb_exchange_token=" . SHORT_LIVED_USER_TOKEN;

    return makeCurlRequest($url);
}

function getLongLivedPageToken($longLivedUserToken) {
    $url = "https://graph.facebook.com/v19.0/" . PAGE_ID . "?fields=access_token&access_token=" . $longLivedUserToken;

    return makeCurlRequest($url);
}

$userTokenResponse = getLongLivedUserToken();
if (!isset($userTokenResponse['access_token'])) {
    die("Failed to get Long-Lived User Token!");
}
$longLivedUserToken = $userTokenResponse['access_token'];
echo "Long-Lived User Token: " . $longLivedUserToken . "\n";

$pageTokenResponse = getLongLivedPageToken($longLivedUserToken);
if (!isset($pageTokenResponse['access_token'])) {
    die(" Failed to get Long-Lived Page Token!");
}
$longLivedPageToken = $pageTokenResponse['access_token'];
echo "Long-Lived Page Access Token: " . $longLivedPageToken . "\n";
