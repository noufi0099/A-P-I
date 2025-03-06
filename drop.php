<?php

$accessToken = 'sl.u.AFlorcRpVHXu0_8SuaxScB1FGsCwSdCTwerpyhXfFKfMaBzFgTDB68jMlEuB_SiecMq7HiQwOMbLEbrXjB-q2zlC8hnhiENYg6m_z7zpxDKp3eWYw4F2MUytArqo3KZaI_9msmb3t8Ci91vWbcKKwrvOKlcvYvBjQ9j06mW4Gk7_qeMogUdbtTA67CdrFD_C5JUGsg97VQbys-F33IMFYL03LyaTzutKxXFZg5naQOKzKP-J4zrhdz7udalsnINCcF8Z7H-I9UxKK0MssVzGBd8ojuWTttvurtK-I9m4FALDo4AIzIL1-LlBMHdBI6LjaTquc_sB1qNX8W3X4s933fVsLzwn9U831R02hr90bCp74xuO53XNFVIQ7HDuQYl2WUVIwLOhDPBYEtKhimvwmqiGGqvSISUpRuoL1h-bJAPw1vYcR3q7PToAki7jwhLkTCiEQkOpusTisAOF72a2dzZLOUSj_vOyLIETzQ23kIRygfA-OoBmENxOYjQpO1zSWKAmqiYmlDjUYrCeOvSq2_z0VrtANvDZ4S_WR6T9F-uwD0mgcEKgQfrF73s6VkaPMD8wneestkMJEqapTS950f-Bm0uB4qJ-Q7KKk6HF3CXPdpcQs3Mx6Gcpv5RYEKui3gAsc2WdHiLhxq0lP_tfFdUE8ucXAXpiBhYARgecmw1SIdJwSA8byGrJf2gUu9FShFQqzZEl5JyFSpP7fGPIF6EaiBjKck0slbydrTEMZaFGF1DRbcMWwPpvWivaf35GZOJRypkw9q94GWTCglXWse9OE4JYDAtsmpARcQ6qzTDWka3GQQHljFH4Cd1UybQ0dXu9P21z82cC6tNq8JbQeVGEtH3GiEMt9pGjWCha3XkLCBH1G9fH3pttpKR_EarJiNMKQuXIyrrGpjsjGO4XFhoBLM5GA5yRSbmY-rRl3eDg6_xI7OIRlBcKDJnspZWBTU8RUhkb9a-JBaY8o8kSdd6T3EO7zG6TgO7vZ7kIxUN029sYqTuB8_YKLQHFw6ZeYiZ707QbD8u1LhXLzKnTf-kDUZYvqYqefU_syPZIvNMY59VdrW2bLqbc2Q3pBSBQlftgniDRa7JrHE1vJqxf1YZr048ZGX5YTneRyY748hvG63izgjdfV3bONB5SV5jkoDhSwYbzuKufTSBYhGFUwcBomgRBuAGtwXHItZWzZQZosBa3qvyyFfInE3w4jgjKRQ4mCkGZM87WLRPhcnmG3-g2MdSSe0B85vu9b-qaiRh8C61fjnPXSZyPfh_u_VvBAQStK57fqWlC9BTbXOYKpc4ZSRIOmsgmL90eR-t5rRjCdmM7OlGGz1UKqaD5z8breq4g0CAomGauu46YSuRRYDL6PdiB-Kdg04M6J2b6tHXIGiMQ3zVb1vp6uTMPnDPiASO88BU4_HnCX0JJDScy3pAk3WRawT6qdpZAvToInWGfVYYZFKwjhq0n_hm4yY_3Vdc';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_FILES['fileToUpload']) || $_FILES['fileToUpload']['error'] !== UPLOAD_ERR_OK) {
        die('Error uploading file');
    }

    $filePath = $_FILES['fileToUpload']['tmp_name'];
    $originalFileName = $_FILES['fileToUpload']['name'];

    $dropboxPath = isset($_POST['dropboxPath']) && !empty(trim($_POST['dropboxPath']))
        ? $_POST['dropboxPath']
        : '/' . $originalFileName;

    $response =uploadFileToDropbox($filePath, $dropboxPath, $accessToken);
}

function uploadFileToDropbox($filePath, $dropboxPath, $accessToken) {
    $fileSize = filesize($filePath);
    $fp = fopen($filePath, 'rb');

    $url = 'https://content.dropboxapi.com/2/files/upload';

    $headers = [
        'Authorization: Bearer ' . $accessToken,
        'Content-Type: application/octet-stream',
        'Dropbox-API-Arg: ' . json_encode([
            'path' => $dropboxPath,
            'mode' => 'add',
            'autorename' => true,
            'mute' => false
        ])
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, fread($fp, $fileSize));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($ch);
    $error = curl_error($ch);

    curl_close($ch);
    fclose($fp);

    if ($error) {
        return 'Curl error: ' . $error;
    }

    return 'Dropbox response: ' . $response;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Upload to Dropbox</title>
</head>
<body>
<form action="" method="post" enctype="multipart/form-data">
    Select file to upload:
    <input type="file" name="fileToUpload" required>
    <br><br>
    <input type="submit" value="Upload to Dropbox">
</form>

</body>
</html>



