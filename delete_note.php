<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];
$id = $_GET["id"];

// chỉ xoá note của chính user
$sql = "DELETE FROM notes WHERE id='$id' AND user_id='$user_id'";
$conn->query($sql);

header("Location: home.php");
exit();