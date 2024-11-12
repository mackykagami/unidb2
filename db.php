<?php
$conn = new mysqli('localhost:3307', 'root', '', 'universitydb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully!";
}

$conn->close();
?>