<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lucky Duck Café - Search</title>
</head>
<body>

	<!-- Vulnerable to Reflected XSS -->
    <h2>Search Results for: <?= $_GET['query'] ?></h2>
    <p>Showing results for "<?= $_GET['query'] ?>"...</p>

	<!-- Fix the reflected XSS vulnerability -->
	<?php /*
	<h2>Search Results for: <?= htmlspecialchars($_GET['query'], ENT_QUOTES, 'UTF-8') ?></h2>
	<p>Showing results for "<?= htmlspecialchars($_GET['query'], ENT_QUOTES, 'UTF-8') ?>"...</p>
	*/ ?>


    <form method="GET">
        <input type="text" name="query" placeholder="Search..." required>
        <input type="submit" value="Search">
    </form>
</body>
</html>