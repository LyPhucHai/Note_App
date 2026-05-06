<?php
session_start();
include("database.php");

// kiểm tra login
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

// thêm note
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];

    $sql = "INSERT INTO notes (user_id, title, content) 
            VALUES ('$user_id', '$title', '$content')";
    $conn->query($sql);
}

// lấy note
$sql = "SELECT * FROM notes WHERE user_id='$user_id' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<h1>My Notes</h1>

<a href="logout.php">Logout</a>

<hr>

<!-- Form tạo note -->
<form method="POST">
    <input name="title" placeholder="Title"><br><br>
    <textarea name="content" placeholder="Content"></textarea><br><br>
    <button>Add Note</button>
</form>

<hr>

<!-- Hiển thị note -->
<?php while($row = $result->fetch_assoc()): ?>
    <div style="border:1px solid #000; margin:10px; padding:10px;">
        <h3><?php echo $row["title"]; ?></h3>
        <p><?php echo $row["content"]; ?></p>
    </div>
<?php endwhile; ?>