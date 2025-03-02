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
        $error = "Invalid credentials!";
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
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login - Lucky Duck Café</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
            	font-family: Arial, sans-serif;
                background-color: #f8f9fa;
            }
            .login-container {
                width: 100%;
                max-width: 400px;
                margin: 100px auto;
                padding: 20px;
                background: white;
                border-radius: 10px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                text-align: center;
            }
        </style>
    </head>
    <body>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        	<div class="container-fluid">
            	<a class="navbar-brand" href="index.php">Lazy Donkey Café</a>
            	<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                	<span class="navbar-toggler-icon"></span>
            	</button>
            	<div class="collapse navbar-collapse" id="navbarNav">
                	<ul class="navbar-nav ms-auto">
                    	<li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    	<li class="nav-item"><a class="nav-link" href="review.php">Reviews</a></li>
                    	<li class="nav-item"><a class="nav-link" href="recommendation.php">Recommendations</a></li>
                    	<li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
                    	<li class="nav-item"><a class="nav-link active" href="admin.php">Admin</a></li>
                	</ul>
            	</div>
        	</div>
    	</nav>
        <div class="login-container">
            <h2 class="mb-3">Admin Login</h2>
            <?php if (isset($error)) echo "<p class='text-danger'>$error</p>"; ?>
            <form method="POST">
                <input type="text" name="username" class="form-control mb-2" placeholder="Username" required>
                <input type="password" name="password" class="form-control mb-2" placeholder="Password" required>
                <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
            </form>
        </div>
    </body>
    </html>
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Lazy Donkey Café</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 80px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand">Admin Panel - Lazy Donkey Café</a>
            <a href="admin.php?logout=true" class="btn btn-danger">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h3 class="mb-4 text-center">Customer Reviews</h3>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Comments</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= htmlspecialchars($row['User'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars($row['Comments'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>
                            <a href="admin.php?delete=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Delete this review?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

</body>
</html>
