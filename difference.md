# Key Difference

Great question! Let's break down the **key differences** between **Reflected XSS**, **Stored XSS**, and **DOM-based XSS**, along with their **affected scope** and how they impact both the **attacker** and **victim**.

### 1. **Reflected Cross-Site Scripting (Reflected XSS)**

**Definition**:
- Reflected XSS occurs when malicious input (such as a script) from a user is immediately reflected by the server and sent back in the response, **without being stored** on the server. This usually happens through **URL parameters** or **HTTP request headers**.

**How it works**:
- An attacker creates a **malicious URL** with a payload embedded in the query string or headers.
- The victim clicks on the malicious link, causing the server to reflect the input (such as the script) back in the web page.
- The victim's browser executes the malicious script, which can steal session cookies, perform actions on behalf of the user, or manipulate the page.

**Scope**:
- **Victim Interaction**: The victim needs to **click on a specially crafted URL** or interact with the site in such a way that their request contains the malicious payload.
- **Attack Vector**: Typically delivered via **email, social media, or chat** with a specially crafted URL.
- **Scope**: Limited to the individual session. The malicious script is executed only for the victim that clicks the URL. It doesn't affect other users or persist on the website.

**Example**:
- A link like: `http://example.com/search?q=<script>alert('XSS')</script>`
- The server dynamically includes the query `q` in the page and executes it, triggering the alert.

**Mitigation**:
- **Input validation and sanitization** to ensure user input is not reflected in the response without being properly escaped.
- Use **HTTP-only and secure cookies** to protect session data.

---

### 2. **Stored Cross-Site Scripting (Stored XSS)**

**Definition**:
- Stored XSS occurs when malicious input is **permanently stored** on the server (e.g., in a database, file system, or other persistent storage). This payload is then served to users on every request to the affected page, making it a **persistent** vulnerability.

**How it works**:
- An attacker injects a malicious script into an input field (e.g., a comment form, review, or profile).
- The server stores the malicious script in a database or other storage medium.
- Every time the page is visited, the stored script is delivered and executed in the browser of anyone who views the page.

**Scope**:
- **Victim Interaction**: Victims do not need to click a link or perform any specific action. They can be **any user who visits the affected page**.
- **Attack Vector**: The malicious script is permanently stored and can affect **all users who access the page** with the script injected.
- **Scope**: Affects **all users** who visit the page where the malicious content is stored. This can be a **widespread attack** as it affects everyone who views the page with the payload.

**Example**:
- An attacker leaves a comment on a blog post: `<script>alert('XSS')</script>`
- The comment is stored in the database, and every visitor who loads the page with the comment will have the alert trigger.

**Mitigation**:
- **Sanitization**: Escape user input and ensure that it’s not treated as executable code.
- **Content Security Policy (CSP)**: Enforce restrictions on what scripts can run on the page.
- **Input Validation**: Validate and sanitize inputs before storing them in the database.

---

### 3. **DOM-based Cross-Site Scripting (DOM-based XSS)**

**Definition**:
- DOM-based XSS is a **client-side** attack, where the malicious script is executed as a result of the page's **client-side JavaScript** processing, without any changes to the server's response. The vulnerability arises when **untrusted data** is used directly in the **DOM** (Document Object Model) without proper sanitization.

**How it works**:
- The attacker injects malicious input (usually via a **URL fragment** or form) that the client-side JavaScript uses to modify the DOM.
- The JavaScript on the page **dynamically** inserts the untrusted input (e.g., URL parameters) into the page’s HTML or executes it as part of an event handler (e.g., `onload`, `onerror`).

**Scope**:
- **Victim Interaction**: The victim must interact with the page, typically by entering data in a form, clicking a link, or by visiting a specially crafted **URL** with malicious parameters.
- **Attack Vector**: The attacker **does not need server-side vulnerabilities**. The attack happens purely on the client-side when JavaScript improperly handles untrusted data.
- **Scope**: Affects **only the victim** who interacts with the page. It’s more localized compared to **stored XSS** but can still be dangerous in certain situations.

**Example**:
- A website dynamically generates content based on the URL, like `http://example.com?name=<script>alert('XSS')</script>`
- JavaScript running on the page dynamically inserts this value into the DOM, executing the script.

**Mitigation**:
- **Sanitize Input**: Ensure that all user input is sanitized and escapes dangerous characters.
- **Use Safe Methods**: Use methods like `textContent` instead of `innerHTML` when manipulating the DOM.

---

### Key Differences and Affected Scope:

| **Aspect**                     | **Reflected XSS**                            | **Stored XSS**                               | **DOM-based XSS**                           |
|---------------------------------|----------------------------------------------|----------------------------------------------|--------------------------------------------|
| **Vulnerability Location**      | Server (reflects the input back in response) | Server (permanent storage like database)     | Client-side (in the browser's DOM)         |
| **Malicious Payload Delivery**  | Delivered via URL parameters or headers      | Delivered via stored data (comments, reviews, etc.) | Delivered via URL parameters or form input |
| **Execution Time**              | Immediate (as soon as the user clicks the link) | Persistent (executed whenever the page is viewed) | Immediate (when JavaScript runs on the page) |
| **Affected Users**              | Individual users (who click the malicious link) | All users who visit the page containing the injected content | Individual users (who interact with the page or view it with malicious content) |
| **Scope**                       | Limited to one user session                  | Affects all users who visit the page         | Affects only the user interacting with the page |
| **Mitigation**                  | URL sanitization, input validation, and encoding | Input validation, sanitization, and content filtering | Client-side sanitization, `textContent` instead of `innerHTML`, event handler sanitization |

---

### Conclusion:

- **Reflected XSS**: The payload is temporarily reflected back to the user in the response and affects only that user's session.
- **Stored XSS**: The malicious script is **persistently stored on the server**, affecting **all users** who visit the vulnerable page.
- **DOM-based XSS**: The payload is **processed by client-side JavaScript** and executed when the user interacts with the page, often using dynamic data insertion.

These three types of XSS attacks all exploit insufficient handling of user input, but the primary differences lie in where the script gets executed (client or server), how it gets injected, and the scope of the affected users.