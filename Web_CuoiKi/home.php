<?php
session_start();
include("database.php");

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION["user_id"];

$sql = "SELECT * FROM notes WHERE user_id='$user_id' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<h1>My Notes</h1>

<a href="add_note.php">➕ Add Note</a> |
<a href="logout.php">Logout</a>

<hr>


<?php if ($result->num_rows > 0): ?>
    <?php while($row = $result->fetch_assoc()): ?>
        <div style="border:1px solid black; margin:10px; padding:10px;">
            <h3><?php echo $row["title"]; ?></h3>
            <p><?php echo $row["content"]; ?></p>

            <a href="delete_note.php?id=<?php echo $row["id"]; ?>"
            onclick="return confirm('Bạn có chắc muốn xoá?')">
            ❌ Delete
            </a>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Chưa có note nào</p>
<?php endif; ?>