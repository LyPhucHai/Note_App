<?php
    $conn = new mysqli("localhost", "root", "", "db_notes");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>