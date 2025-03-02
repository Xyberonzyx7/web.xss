<?php
header("Content-Type: text/html; charset=UTF-8");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recommended Coffee</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
			margin-top: 40px;
        }
        .recommendations {
            margin-top: 20px;
            text-align: left;
        }
        .recommendation {
            padding: 10px;
            background: #d4a373;
            color: white;
            margin: 10px 0;
            border-radius: 5px;
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
                    <li class="nav-item"><a class="nav-link active" href="recommendation.php">Recommendations</a></li>
                    <li class="nav-item"><a class="nav-link" href="search.php">Search</a></li>
                    <li class="nav-item"><a class="nav-link" href="admin.php">Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>
	<div class="xss-warning">
    	<strong>Warning:</strong> This page is vulnerable to <b>DOM-based XSS</b>. Be cautious with inputs!
	</div>
    <div class="container">
        <h2>Coffee Recommendations</h2>
        <p>Select your favorite type:</p>
        <input type="text" id="coffeeType" placeholder="Enter coffee type...">
        <button onclick="getRecommendations()">Get Recommendations</button>
        
        <div class="recommendations" id="recommendationList"></div>
    </div>
    
    <script>
        function getRecommendations() {
            let coffeeType = document.getElementById("coffeeType").value;
            let output = `<h3>Best choices for: ${coffeeType}</h3>`;
            
            let menu = {
                "espresso": ["Espresso Shot", "Americano", "Macchiato"],
                "latte": ["Vanilla Latte", "Caramel Latte", "Hazelnut Latte"],
                "cold brew": ["Classic Cold Brew", "Nitro Cold Brew", "Vanilla Sweet Cream Cold Brew"]
            };
            
            let recommendations = menu[coffeeType.toLowerCase()] || ["Sorry, we don't have that!"];
            recommendations.forEach(item => {
                output += `<div class='recommendation'>${item}</div>`;
            });
            
            document.getElementById("recommendationList").innerHTML = output;
        }
    </script>
    
    <script>
        // DOM-based XSS vulnerability
        let params = new URLSearchParams(window.location.search);
        let userCoffee = params.get("coffeeType");
        if (userCoffee) {
            document.getElementById("coffeeType").value = userCoffee;

			// ❌ vulnerable to DOM-based XSS
            document.getElementById("recommendationList").innerHTML = `<h3>Best choices for: ${userCoffee}</h3>`;

			// ✅ Fix the DOM-based XSS vulnerability
			// document.getElementById("recommendationList").textContent = `<h3>Best choices for: ${userCoffee}</h3>`;
        }
    </script>
</body>
</html>