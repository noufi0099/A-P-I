<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $recaptchaSecret = "6LfTye8qAAAAAOd4gC2i2RUWTAV-mphkMBtmdyA6";
    $recaptchaResponse = $_POST["g-recaptcha-response"];
    
    $verifyURL = "https://www.google.com/recaptcha/api/siteverify";
    $response = file_get_contents($verifyURL . "?secret=" . $recaptchaSecret . "&response=" . $recaptchaResponse);
    $responseData = json_decode($response);
    
    if ($responseData->success && $responseData->score >= 0.5) {
        echo "reCAPTCHA verified. Login successful!";
    } else {
        echo "reCAPTCHA verification failed. Please try again.";
    }
} else {
    echo "Invalid request.";
}
?>
