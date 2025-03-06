<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $page_id = $_POST["page_id"];
    $page_token = $_POST["page_token"];

    function getForms($page_id, $page_token) {
        $url = "https://graph.facebook.com/v22.0/{$page_id}/leadgen_forms?fields=id,name&access_token={$page_token}";
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

    $forms = getForms($page_id, $page_token);

    if (isset($forms['data']) && count($forms['data']) > 0) {
        echo "<ul>";
        foreach ($forms['data'] as $form) {
            echo "<li>{$form['name']}</li>";
        }
        echo "</ul>";
    } else {
        echo "No forms found for this page.";
    }
}
?>
