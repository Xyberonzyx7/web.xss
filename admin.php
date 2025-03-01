<?php
session_start();
include 'db.php';

// Handle login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username === "admin" && $password === "admin") {
        $_SESSION['admin_logged_in'] = true;
    } else {
        echo "<p style='color: red;'>Invalid credentials!</p>";
    }
}

// Handle logout
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: admin.php");
    exit();
}

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) { ?>
    <form method="POST">
        <h2>Admin Login</h2>
        <input type="text" name="username" required placeholder="Username"><br>
        <input type="password" name="password" required placeholder="Password"><br>
        <input type="submit" name="login" value="Login">
    </form>
    <?php exit();
}

// Handle delete review
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $conn->prepare("DELETE FROM reviews WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: admin.php"); // Refresh after deleting
    exit();
}

// Fetch all reviews
$result = $conn->query("SELECT * FROM reviews ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel - Lucky Duck Café</title>
</head>
<body>
    <h2>Admin Panel</h2>
    <a href="admin.php?logout=true">Logout</a>
    <h3>Customer Reviews:</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Comments</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['User'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($row['Comments'], ENT_QUOTES, 'UTF-8') ?></td>
                <td><a href="admin.php?delete=<?= $row['id'] ?>" onclick="return confirm('Delete this review?')">Delete</a></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
