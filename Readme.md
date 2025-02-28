Three different pages for a **coffee shop website** to demonstrate each of the **XSS vulnerabilities**:

1. **Reflected Cross-Site Scripting (Reflected XSS)**
2. **Stored Cross-Site Scripting (Stored XSS)**
3. **DOM-based Cross-Site Scripting (DOM XSS)**

I'll outline each scenario with a **vulnerable website page**, explain how each XSS works, and give a potential use case where the vulnerability could be exploited.

### 1. **Reflected Cross-Site Scripting (Reflected XSS)**

In **Reflected XSS**, the malicious input is immediately reflected back to the user by the web server without any sanitization. This happens when the input is processed and returned by the web server.

#### Use Case: **"Search Bar" in the Coffee Shop Website**
A user can search for their favorite coffee or a menu item, and the search term is reflected back on the page.

**Vulnerable PHP Page (search.php)**

```php
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
```

#### Scenario:
1. An attacker could craft a URL like:
   ```
   http://localhost/search.php?query=<script>alert('XSS')</script>
   ```
2. When the victim clicks on the link, the script executes, showing an alert box. The attacker could inject a more harmful payload (e.g., stealing cookies).

**Potential Damage**:
- Stealing session cookies.
- Redirecting users to malicious websites.

---

### 2. **Stored Cross-Site Scripting (Stored XSS)**

> [!NOTE]
> In this scenario, you need to create a `reviews.txt` file at the same directory as `review.php`
> Also make sure that `reviews.txt` has write permission for Apache
>
> Steps:
> `sudo touch reviews.txt`
> `sudo chmod 777 reviews.txt`

In **Stored XSS**, the attacker’s input is saved to the server and reflected back to all users who visit the page. It can persist across different sessions and affect multiple users.

#### Use Case: **"Customer Reviews" Section on the Coffee Shop Website**
The coffee shop allows users to leave reviews on different drinks, but the website doesn't sanitize the input before saving it to the database.

**Vulnerable PHP Page (review.php)**

```php
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
```

#### Scenario:
1. An attacker submits a review like this:
   ```html
   <script>alert('XSS')</script>
   ```
2. The review is stored in the `reviews.txt` file and will appear for any user who visits the reviews page. When any user views the page, the injected script executes.

**Potential Damage**:
- If the attacker injects malicious JavaScript, they could steal session cookies, hijack accounts, or perform other malicious actions.
- This could impact all users visiting the reviews section.

---

### 3. **DOM-based Cross-Site Scripting (DOM XSS)**

In **DOM-based XSS**, the client-side JavaScript itself handles and processes user input, and the vulnerability arises due to improper handling of the data on the client side, without any server interaction.

#### Use Case: **"Coffee Recommendation" Based on User Input**
The coffee shop website uses JavaScript to give recommendations based on user input (e.g., favorite coffee flavor).

**Vulnerable HTML Page (recommendation.html)**

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Shop - Coffee Recommendation</title>
</head>
<body>
    <h1>Coffee Shop - Find Your Perfect Coffee</h1>

    <label for="flavor">Enter your favorite coffee flavor:</label>
    <input type="text" id="flavor" name="flavor">
    <button onclick="getRecommendation()">Get Recommendation</button>

    <h3>Your Recommendation:</h3>
    <div id="recommendation"></div>

    <script>
        function getRecommendation() {
            var flavor = document.getElementById('flavor').value;

            // Vulnerable: inserting input into HTML without sanitization (DOM-based XSS)
            document.getElementById('recommendation').innerHTML = 
                "We recommend the " + flavor + " latte!<br>";

            // Added example: Injecting another XSS vulnerability in the HTML context.
            document.getElementById('recommendation').innerHTML += 
                "<img src='invalid.jpg' onerror='alert(\"XSS via Image\")' />";
        }
    </script>
</body>
</html>

```
Expected Outcome:

    When you input <script>alert('XSS')</script>, it won't trigger an alert, but the vulnerable code will still insert the input into the DOM.
    The XSS payload won't be executed directly, but the onerror event in the <img> tag will still trigger the alert because the image fails to load.
    The alert box should pop up with the message: "XSS via Image".
#### Scenario:
1. An attacker could submit a malicious flavor like:
   ```html
   <script>alert('XSS')</script>
   ```
2. When you input <script>alert('XSS')</script>, it won't trigger an alert, but the vulnerable code will still insert the input into the DOM.
- The XSS payload won't be executed directly, but the onerror event in the <img> tag will still trigger the alert because the image fails to load.
- The alert box should pop up with the message: "XSS via Image".

**Potential Damage**:
- The attacker could execute arbitrary JavaScript, which could lead to session hijacking, redirecting the user to phishing sites, or other malicious actions.
- Since this happens on the client-side, the attack only requires the victim to interact with the page.

---

### Summary of the Three Vulnerabilities:

1. **Reflected XSS**:
   - Occurs when user input is reflected immediately by the server (e.g., via a search bar).
   - Example: An attacker could send a link with a malicious payload that runs in the user's browser when clicked.

2. **Stored XSS**:
   - Occurs when malicious input is stored by the server (e.g., in a review or comment section).
   - Example: An attacker submits a review with a malicious script, and every user who views the review will have their browser execute the script.

3. **DOM-based XSS**:
   - Occurs when client-side JavaScript processes unsanitized user input (e.g., a recommendation form).
   - Example: A user enters a malicious input that gets inserted directly into the page via `innerHTML`, allowing for script execution.

---

### Demonstration:
To demonstrate these vulnerabilities, you can:
1. **Set up each of these PHP or HTML pages** on your local server.
2. Test each scenario:
   - **For Reflected XSS**: Enter a search query like `<script>alert('XSS')</script>`.
   - **For Stored XSS**: Submit a review like `<script>alert('XSS')</script>`.
   - **For DOM-based XSS**: Enter a flavor like `<script>alert('XSS')</script>` in the input field.

These examples will help showcase the dangers of XSS and why proper sanitization, validation, and encoding are crucial to protect web applications from such attacks.

Let me know if you need further clarification or adjustments to these pages!