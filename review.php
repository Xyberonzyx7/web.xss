<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop - Reviews</title>
</head>
<body>
    <h1>Customer Reviews</h1>

    <form action="review.php" method="POST">
        <label for="review">Leave a review:</label>
        <textarea id="review" name="review"></textarea>
        <button type="submit">Submit</button>
    </form>

    <h3>Latest Reviews:</h3>
    <div id="reviews">
        <?php
        // Assume this is getting reviews from a database
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $review = $_POST['review'];
            // Vulnerable: The review is saved without sanitization
            file_put_contents('reviews.txt', $review . "\n", FILE_APPEND);
        }

        // Display reviews
        $reviews = file('reviews.txt');
        foreach ($reviews as $review) {
            echo "<p>" . $review . "</p>"; // This is where the malicious script can run
        }
        ?>
    </div>
</body>
</html>
