<?php
include 'db.php'; // Database connection

$searchResults = [
    "Caramel Latte", "Vanilla Cold Brew", "Hazelnut Mocha", "Espresso Shot", "Matcha Latte", "Chai Tea", 
    "Iced Americano", "Pumpkin Spice Latte", "Cappuccino", "French Vanilla" 
];
shuffle($searchResults); // Randomize results
$searchResults = array_slice($searchResults, 0, 6); // Select 6 random items
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lazy Donkey Café - Search</title>
	<link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container { width: 80%; margin: auto; padding: 20px; }
		.container h2, h5, form {margin: 20px auto;}
		.search-bar { padding: 10px; width: 50%; border: 1px solid #ccc; border-radius: 5px; }
        .search-btn { padding: 10px 15px; background-color: #ff9800; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .search-btn:hover { background-color: #e68900; }
		.cards {
    		display: flex;
    		flex-wrap: wrap;
    		gap: 15px;
    		justify-content: center;
		}
		.card {
    		width: 200px; /* Adjust as needed */
    		background: white;
    		padding: 10px;
    		border-radius: 8px;
    		box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    		text-align: center;
    		overflow: hidden;
		}
		.card img {
    		width: 100%;
    		height: 150px; /* Fixed height to maintain consistency */
    		object-fit: cover; /* Ensures the image fills the area without distortion */
    		border-radius: 8px;
		}
        .card h3 { margin-top: 10px; font-size: 18px; }
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
                    <li class="nav-item"><a class="nav-link active" href="search.php">Search</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>
	<div class="xss-warning">
    	<strong>Warning:</strong> This page is vulnerable to <b>Reflected XSS</b>. Be cautious with inputs!
	</div>
	<div class="container">
		<h2>Search Our Menu</h2>

    	<form method="GET">
        	<input type="text" name="query" placeholder="Search..." required>
        	<input type="submit" value="Search">
    	</form>

		<!--❌ Vulnerable to reflected XSS -->
		<h5>Search Results for: <?= isset($_GET['query']) ? $_GET['query'] : 'All Items' ?></h5>


		<!--✅ Fix the reflected XSS vulnerability -->
		<!-- <h5>Search Results for: <?= isset($_GET['query']) ? htmlspecialchars($_GET['query'], ENT_QUOTES, 'UTF-8') : 'All Items' ?></h5> -->

		<div class="cards">
            <?php foreach ($searchResults as $item): ?>
                <div class="card">
                    <img src="./assets/<?= htmlspecialchars($item) ?>.jpg" alt="<?= htmlspecialchars($item) ?>">
                    <h3><?= htmlspecialchars($item) ?></h3>
                </div>
            <?php endforeach; ?>
        </div>
	</div>
</body>
</html>