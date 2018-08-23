---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](https://photobook.test/docs/collection.json)
<!-- END_INFO -->

#Authentication
<!-- START_a925a8d22b3615f12fca79456d286859 -->
## Get a JWT via given credentials.

> Example request:

```bash
curl -X POST "https://photobook.test/api/auth/login" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/auth/login",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
"{\naccess_token: \"asdasd\"\n}"
```

### HTTP Request
`POST api/auth/login`


<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_19ff1b6f8ce19d3c444e9b518e8f7160 -->
## Log the user out (Invalidate the token).

> Example request:

```bash
curl -X POST "https://photobook.test/api/auth/logout" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/auth/logout",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/auth/logout`


<!-- END_19ff1b6f8ce19d3c444e9b518e8f7160 -->

<!-- START_994af8f47e3039ba6d6d67c09dd9e415 -->
## Refresh a token.

> Example request:

```bash
curl -X POST "https://photobook.test/api/auth/refresh" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/auth/refresh",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/auth/refresh`


<!-- END_994af8f47e3039ba6d6d67c09dd9e415 -->

<!-- START_a47210337df3b4ba0df697c115ba0c1e -->
## Get the authenticated User.

> Example request:

```bash
curl -X POST "https://photobook.test/api/auth/me" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/auth/me",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/auth/me`


<!-- END_a47210337df3b4ba0df697c115ba0c1e -->

<!-- START_2e1c96dcffcfe7e0eb58d6408f1d619e -->
## Create a new user instance after a valid registration.

> Example request:

```bash
curl -X POST "https://photobook.test/api/auth/register" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/auth/register",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/auth/register`


<!-- END_2e1c96dcffcfe7e0eb58d6408f1d619e -->

#general
<!-- START_0ede357cfa17e8746504eb85c997884f -->
## Send a reset link to the given user.

> Example request:

```bash
curl -X POST "https://photobook.test/api/auth/password/email" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/auth/password/email",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/auth/password/email`


<!-- END_0ede357cfa17e8746504eb85c997884f -->

<!-- START_fa35e99472a4a21b58597f0aded2da77 -->
## Display a listing of the resource.

> Example request:

```bash
curl -X GET "https://photobook.test/api/photo" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/photo",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/photo`

`HEAD api/photo`


<!-- END_fa35e99472a4a21b58597f0aded2da77 -->

<!-- START_7c12a8a3e592f166fb4c06abdb4362f7 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl -X POST "https://photobook.test/api/photo" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/photo",
    "method": "POST",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`POST api/photo`


<!-- END_7c12a8a3e592f166fb4c06abdb4362f7 -->

<!-- START_8750d81b62673c94db36996a4b260f8f -->
## Display the specified resource.

> Example request:

```bash
curl -X GET "https://photobook.test/api/photo/{photo}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/photo/{photo}",
    "method": "GET",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```

> Example response:

```json
null
```

### HTTP Request
`GET api/photo/{photo}`

`HEAD api/photo/{photo}`


<!-- END_8750d81b62673c94db36996a4b260f8f -->

<!-- START_a3d33973d9c43a49ce6da44da4ddb25a -->
## Update the specified resource in storage.

> Example request:

```bash
curl -X PUT "https://photobook.test/api/photo/{photo}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/photo/{photo}",
    "method": "PUT",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`PUT api/photo/{photo}`

`PATCH api/photo/{photo}`


<!-- END_a3d33973d9c43a49ce6da44da4ddb25a -->

<!-- START_9d79d5e8e712286b89639e8525993a47 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl -X DELETE "https://photobook.test/api/photo/{photo}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "https://photobook.test/api/photo/{photo}",
    "method": "DELETE",
    "headers": {
        "accept": "application/json"
    }
}

$.ajax(settings).done(function (response) {
    console.log(response);
});
```


### HTTP Request
`DELETE api/photo/{photo}`


<!-- END_9d79d5e8e712286b89639e8525993a47 -->

