<?php
$accessToken = 'sl.u.AFkE-aIZWnUf-GG_HgmwbQL7sK6QbcIvSgDe1oSMgo6wuKT9HaqBKdk40GOW4eKQLmi8nNwDUTi5mVVdwoyi2tTOAaKjukh9dswdgjx3DMb8SsWwAYJ5wJyM_RNitBW0I7nbHlHHYbvozJ8xDfCe4adobEHVVLd4FDBDih0kFOgboFxyeQ2NJjc8dmrD0vUmCH-CGzVazT01nQgd10kGkSJbo_i6YoR7jXmxxnz2SPdqbO1ydBRtMFBmyAFpwgmEyavZTsUtKgnrJWCvP_OvVFwnYirZOfaZgrn5ePdujJ0sIpIv4vdTNeENbz0f6LYAXAkR89vDcgLBfiiw2Ox-ce-0WZfhXlZHR-EqQPCiUMS7eO7M5p98YhjCMfguEJM_DegoimE9lCwE2nKW7cZx9WYuu5pgsgQbeSZxoFAwaYbOf_zrkgbke0ZClpK_xXBuJJHJppG2UdX7Zwhjg5dRHQUb96bf22ffNWFpiJXk8AB-vG-x0R2j3zg_o0MLDTWTiY59UXcs-QBvHO5wInOEA5rmN6oBUfoa27yCsZFAm4qbhdd8M4a6ZIQbLEQYjm_7GU6swVtVFpkpAl1jrwlwVZedd0x6faLjBiUtMA8oVI9eqGCvgYwi5Xz2gCUt5V2MMENLGouAj2tFdbb8p4ehC73n3KxhxLUYvRm67ox7ehVavzsBmXCtAeQSnVpQ33rBgNodSKPRh-XVX2pE2fAu1gNLkRI_LPI1ncfCIF9nxgUp5hrTE1E8W45qcXpOELdMAcxr9vT0cnoG8Nh5cWn9IrqgWB1FG1ay8Tb6T6uKt4HnA0h4qqIQUyWt-FZtUS1yGih2_lo1eGhha4-dvyq8eDZ4lVmKUuysdj2czBc4pxwDznn_9cDhjOwHwvL-XCXOwIrngrIrZJzhnadg7n8pTTRCjVRo6fIqBJtOh3NLZ8bUvjmmF8_MhC3doqGkJE5D0Kgmp7ANyFr_vFoQ56YnMpicOMWtap9KZgoX_ST_QnxQ-T1o23e4V1CDqGxjjlyUQufD61rvUlAT4XYeHp9PofNdxG0lytMasI-acW6CxeuV4GZy_jI43kxH8YJXIayiDSkec0R4SuKhPTl-rSEMHPEAzcJnavEcfgnV44DkKZoWq3ZJXuuBEiewVYEC1FcjsIVqfIJOA863_033UYlN7Q_Kpx9H7nF3euVLARPYr3lmN3vY11EwAuc5Scx43_C3UMNcDhVlTbf8nDHbtn97CooWJdUbakcNHgueQKS2658bUXRNaKK9wI_cFkm1xrTjXTMcqwd_zIW1VI8o7gZ9lKuFESE1PAjl2d9ap3lZ7Z41dUkfbnnVvTViHAYOkl6d4SJCVrqPQWO6ZvKU_wJS67LOmKI1-U8B8M-_Z8MhuLqZfI-V0OBVvuA0ZdHAQbaXGt48sNJ12EsP_dJvjI7smKNdeaQ29FeDZG1EDoNh1mqmwtyN_C22AaXCj4reNOx1Z4Q';
$filePath = '/test/thumb.jpg'; 

$url = 'https://api.dropboxapi.com/2/files/delete_v2';

$data = json_encode([
    'path' => $filePath
]);

$headers = [
    "Authorization: Bearer $accessToken",
    "Content-Type: application/json"
];

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

if ($httpCode == 200) {
    echo "File deleted successfully: " . htmlspecialchars($filePath);
} else {
    echo "Failed to delete file. Response: $response";
}

curl_close($ch);
?>
