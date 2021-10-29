some kind of mini-framework (no name yet)

# Quickstart

Create html documents in `pages/`

Create reusable template parts in `blocks/`

Add `.css` and `.js` files next to your `.html` with the same filename for automatic linking.

Compiled pages are stored under `public/`

## The `<z>` tag (temporary name (i think)):

<z `variables to replace in the template`> `the name of the block without .html` </z>

`<z foo="bar">file</z>` will render `blocks/file.html` and replace occurences of `$foo` with `bar`.

`<z>` tags can be infinitely nested.

---

# Exemple:

Document: `page/index.html`:
```
<z title-variable="Sup fool">my-header</z>
hello guys
</body>
```

Block: `blocks/my-header.html`:
```
<!doctype html>
<head>
<title>$variable-title</title>
</head>
<body>
<h1>Hello and welcome to this site</h1>
```

Result: `public/index.html`:

```
<!doctype html>
<head>
<title>Sup fool</title>
</head>
<body>
<h1>Hello and welcome to this site</h1>
hello guys
</body>
```
