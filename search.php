<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop - Search</title>
</head>
<body>
    <h1>Coffee Shop - Search Menu</h1>

    <form action="search.php" method="GET">
        <label for="search">Search for your favorite coffee:</label>
        <input type="text" id="search" name="query" />
        <button type="submit">Search</button>
    </form>

    <h3>Your Search Results:</h3>
    <p>
        <?php
        if (isset($_GET['query'])) {
            echo "You searched for: " . $_GET['query'];  // This is vulnerable to reflected XSS
        }
        ?>
    </p>
</body>
</html>
