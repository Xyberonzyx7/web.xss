<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lucky Duck Café - Recommendations</title>
</head>
<body>
    <h2>Find a Café Near You:</h2>
    <label for="location">Select Location:</label>
    <select id="location">
        <option value="Surrey">Surrey</option>
        <option value="Vancouver">Vancouver</option>
    </select>
    <button onclick="showCafe()">Find Cafés</button>

    <p id="cafe"></p>

    <script>
        var params = new URLSearchParams(window.location.search);
        var locationParam = params.get('location');

        // 🚨 VULNERABLE: Uses innerHTML, allowing script injection
        if (locationParam) {
            document.getElementById("cafe").innerHTML = "Recommended Café: " + locationParam;
        }

        function showCafe() {
            var location = document.getElementById("location").value;
            var newUrl = window.location.pathname + "?location=" + location; // No encoding!

            window.history.pushState({}, '', newUrl);

            // 🚨 VULNERABLE: Directly injecting user input into innerHTML
            document.getElementById("cafe").innerHTML = "Recommended Café: " + location;
        }
    </script>
</body>
</html>
