Fetch leads data and save to leads.json file

<?php
$formId = '2130860473999873';
$pageAccessToken = 'EAAIwds5w2SoBOZCbWz1y6vZB2ZCfsDrev7ggrlvDo9b8KR8kvkgVmg3zcj1D86g0GBvPip0NXlluIywNpTyideHZChlkhAN65NrLC6uuu7TwGjv5ZC0ZBbktsqAaCepnjErFbgZBX8e0jev5Eog703l2ZCBzJ1fSLIoguEik2qK5JZBYGxuqljfMVWWva7c8X5Lr8gjwaoeSmAw3Wkz7JXSP5DqibdZB9BTz7h8KoZD';

$url = "https://graph.facebook.com/v19.0/{$formId}/leads?access_token={$pageAccessToken}";

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);

if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
    curl_close($ch);
    exit;
}

curl_close($ch);

$data = json_decode($response, true);

if (isset($data['error'])) {
    echo "API Error: " . $data['error']['message'];
    exit;
}

$result = file_put_contents('leads.json', json_encode($data, JSON_PRETTY_PRINT));

if ($result !== false) {
    echo "Leads successfully saved to leads.json";
} else {
    echo "Failed to write leads to file.";
}
?>
