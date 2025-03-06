<?php
$parentFolder = 'uploads';  // Change this to your main folder on the server

// Get all folders in the parent directory
$folders = array_filter(glob($parentFolder . '/*'), 'is_dir');

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['selected_folder'])) {
    $selectedFolder = $_POST['selected_folder'];
    $fullPath = realpath($selectedFolder);

    echo "<h3>Selected Folder Path:</h3>";
    echo "<p>" . htmlspecialchars($fullPath) . "</p>";

    echo "<h3>Contents of Folder:</h3>";
    $files = scandir($selectedFolder);

    foreach ($files as $file) {
        if ($file !== "." && $file !== "..") {
            echo "File: " . htmlspecialchars($file) . "<br>";
        }
    }
}
?>

<h3>Select a Folder:</h3>
<form method="POST">
    <select name="selected_folder">
        <?php
        foreach ($folders as $folder) {
            echo "<option value='$folder'>" . basename($folder) . "</option>";
        }
        ?>
    </select>
    <button type="submit">Show Folder Contents</button>
</form>
