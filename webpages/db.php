<?php
$conn = new mysqli("localhost", "root", "", "db_745"); // Updated database name

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
