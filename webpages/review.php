<?php
include 'db.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {

	// Vulnerable to Stored XSS
    $username = $_POST['username']; // Prevents XSS
    $review = $_POST['review'];


	// prevent XSS
	// $username = htmlspecialchars($_POST['username'], ENT_QUOTES, 'UTF-8'); // Prevents XSS
    // $review = htmlspecialchars($_POST['review'], ENT_QUOTES, 'UTF-8');

    $stmt = $conn->prepare("INSERT INTO reviews (User, Comments) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $review);

    if ($stmt->execute()) {
        // Redirect to prevent form resubmission
        header("Location: review.php?success=1");
        exit(); // Stop further execution
    } else {
        echo "<p style='color: red;'>Error: " . $stmt->error . "</p>";
    }
}

// $result = $conn->query("SELECT * FROM reviews");
$result = $conn->query("SELECT * FROM reviews ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
   	<title>Lazy Donkey Café</title>
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
                    <li class="nav-item"><a class="nav-link active" href="review.php">Reviews</a></li>
                    <li class="nav-item"><a class="nav-link" href="recommendation.php">Recommendations</a></li>
                    <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>
	<div class="xss-warning">
    	<strong>Warning:</strong> This page is vulnerable to <b>Stored XSS</b>. Be cautious with inputs!
	</div>
    <div class="container">
        <h1 class="title">Customer Reviews</h1>
        <div class="review-form">
            <h2>Leave a Review:</h2>
            <form method="POST">
                <input type="text" name="username" required placeholder="Your Name">
                <textarea name="review" required placeholder="Write your review..."></textarea>
                <input type="submit" value="Submit" class="btn">
            </form>
        </div>
        <div class="reviews-list">
            <h2>Recent Reviews:</h2>
            <div class="reviews">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="review-box">
                        <p><strong><?= htmlspecialchars($row['User'], ENT_QUOTES, 'UTF-8') ?>:</strong></p>

						<!-- ❌ Vulnerable to Stored XSS -->
                        <p><?= $row['Comments'] ?></p>

						<!-- ✅ Fix the Stored XSS vulnerability -->
                        <!-- <p><?= htmlspecialchars($row['Comments'], ENT_QUOTES, 'UTF-8') ?></p> -->
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</body>
</html>

<style>
	body {
		font-family: Arial, sans-serif;
		background-color: #f8f9fa;
		margin: 0;
		padding: 20px;
		text-align: center;
	}
    .container {
        width: 60%;
        background: white;
        padding: 10;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        margin-top: 40px;
    }
    .title {
        text-align: center;
        color: #333;
    }
    .review-form {
        margin-bottom: 20px;
    }
    input, textarea {
        width: 100%;
        padding: 10px;
        margin-top: 5px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }
    .btn {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 10px 15px;
        cursor: pointer;
        margin-top: 10px;
        border-radius: 5px;
    }
    .btn:hover {
        background-color: #218838;
    }
    .reviews-list {
        margin-top: 20px;
    }
    .review-box {
        background: #fff;
        padding: 10px;
        margin-bottom: 10px;
        border-left: 5px solid #007bff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
</style>
