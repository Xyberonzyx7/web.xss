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

$result = $conn->query("SELECT * FROM reviews");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lucky Duck Café - Reviews</title>
	<script>
    	window.onload = function() {
        	document.getElementById("reviews").innerHTML = ""; // Clear displayed reviews
    	};
	</script>

</head>
<body>
    <h2>Leave a Review:</h2>
    <form method="POST">
        <input type="text" name="username" required placeholder="Your Name">
        <textarea name="review" required placeholder="Write your review..."></textarea>
        <input type="submit" value="Submit">
    </form>

    <h2>Customer Reviews:</h2>
    <?php while ($row = $result->fetch_assoc()): ?>

		<!-- Vulnerable to Stored XSS -->
        <p><strong><?= $row['User'] ?>:</strong> <?= $row['Comments'] ?></p>

		<!-- Fixed Stored XSS -->
		<?php /*
		<p><strong><?= htmlspecialchars($row['User'], ENT_QUOTES, 'UTF-8') ?>:</strong> 
        <?= htmlspecialchars($row['Comments'], ENT_QUOTES, 'UTF-8') ?>
		*/ ?>

    <?php endwhile; ?>
</body>
</html>