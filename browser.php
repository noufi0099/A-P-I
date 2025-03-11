<?php
header("Content-Type: application/json");

$notifications = [
    ["title" => "New Message", "message" => "You have a new message in your inbox!"],
    ["title" => "Reminder", "message" => "Don't forget to complete your tasks!"],
    ["title" => "Weather Update", "message" => "It's going to rain today, take an umbrella!"]
];

$randomNotification = $notifications[array_rand($notifications)];

echo json_encode($randomNotification);
?>
