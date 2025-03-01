<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lazy Duncky Café</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Welcome to Lucky Duck Café 🦆☕</h1>
    <p>Explore our menu, leave reviews, and get recommendations!</p>

    <ul>
        <li><a href="review.php">📜 Customer Reviews</a> (Stored XSS)</li>
        <li><a href="search.php?query=coffee">🔍 Search for Drinks</a> (Reflected XSS)</li>
        <li><a href="recommendation.php">🤖 AI Recommendations</a> (DOM-Based XSS)</li>
    </ul>
</body>
</html>