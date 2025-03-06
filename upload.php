<?php

$folderPath = 'C:\Users\noufa\OneDrive\Pictures';  

    $absolutePath = realpath($folderPath);
    
    echo $absolutePath ;

    $items = scandir($folderPath);

    echo "<ul>";
    foreach ($items as $item) {
        if ($item !== '.' && $item !== '..') {
            echo "<li>" . $item . "</li>";
        }
    }
    echo "</ul>";

    echo $folderPath;
?>
