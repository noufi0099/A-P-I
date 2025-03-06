Listing of Pages connected a fb account

<?php
define("BUSINESS_ACCESS_TOKEN", "EAAIwds5w2SoBO87ZB1DRK1AAIe3jX9ZBWF17DV48f5K4L2RY9oajB01F0g8R72QQqhWk9VcArrvwAKAl0w9sgAZBbeaBwZCpnyZCMS0Sbf5btc1y3ZB7b9PZAPCjFWv5J8CLCj4ZBfUFGDI9qali53Dq5pZCBr7D2JHZCLmZBk2TccQa7YUXvkBYVvoO2mWt3bjHKbvZBSHbNNPHdv0ZCG1osuAR9UmJ5mf0IM3OVyPIZD");
define("BUSINESS_ID", "629155096533446");

function getBusinessPages() {
    $url = "https://graph.facebook.com/v22.0/" . BUSINESS_ID . "/owned_pages?fields=id,name,category,access_token&access_token=" . BUSINESS_ACCESS_TOKEN;
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

// Fetch business pages
$pages = getBusinessPages();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Select a Business Page</title>
</head>
<body>
    <select id="businessPageDropdown" onchange="fetchForms(this.value)">
        <option value="">Select a Business Page</option>
        <?php
        if (isset($pages['data']) && count($pages['data']) > 0) {
            foreach ($pages['data'] as $page) {
                echo "<option value='{$page['id']}' data-token='{$page['access_token']}'>{$page['name']} ({$page['category']})</option>";
            }
        } else {
            echo "<option value=''>No pages found</option>";
        }
        ?>
    </select>

    <div id="formsList"></div>

    <script>
    function fetchForms(pageId) {
        if (!pageId) {
            document.getElementById("formsList").innerHTML = "";
            return;
        }

        // Get selected page's access token
        let dropdown = document.getElementById("businessPageDropdown");
        let selectedOption = dropdown.options[dropdown.selectedIndex];
        let pageToken = selectedOption.getAttribute("data-token");

        // Call PHP script via AJAX
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "fetch_forms.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("formsList").innerHTML = xhr.responseText;
            }
        };

        xhr.send("page_id=" + pageId + "&page_token=" + pageToken);
    }
    </script>
</body>
</html>
