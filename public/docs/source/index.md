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
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#general
<!-- START_039715a551c707878871289fd02e815f -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/api/post" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/post",
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
[]
```

### HTTP Request
`GET api/post`

`HEAD api/post`


<!-- END_039715a551c707878871289fd02e815f -->
<!-- START_112f38c169c6b664068ce459c85b7d63 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/api/post" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/post",
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
`POST api/post`


<!-- END_112f38c169c6b664068ce459c85b7d63 -->
<!-- START_77dcf33b95b4bfdebfb68f98c9d3b382 -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/api/post/{post}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/post/{post}",
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
`GET api/post/{post}`

`HEAD api/post/{post}`


<!-- END_77dcf33b95b4bfdebfb68f98c9d3b382 -->
<!-- START_489ced4bef0ee4943abe65e9c6005a89 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/api/post/{post}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/post/{post}",
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
`PUT api/post/{post}`

`PATCH api/post/{post}`


<!-- END_489ced4bef0ee4943abe65e9c6005a89 -->
<!-- START_56e843a0c10055309a0ed18ee61a9050 -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/api/post/{post}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/post/{post}",
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
`DELETE api/post/{post}`


<!-- END_56e843a0c10055309a0ed18ee61a9050 -->
<!-- START_fc9102c0a0347880f93fe8fe45223d09 -->
## Display a listing of the resource.

> Example request:

```bash
curl "http://localhost/api/tag" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/tag",
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
[
    {
        "id": 1,
        "name": "tag1"
    }
]
```

### HTTP Request
`GET api/tag`

`HEAD api/tag`


<!-- END_fc9102c0a0347880f93fe8fe45223d09 -->
<!-- START_052af4788411dd7af6ee629efdac9670 -->
## Store a newly created resource in storage.

> Example request:

```bash
curl "http://localhost/api/tag" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/tag",
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
`POST api/tag`


<!-- END_052af4788411dd7af6ee629efdac9670 -->
<!-- START_ea2909dfa1f07df5a1f5365024e334b2 -->
## Display the specified resource.

> Example request:

```bash
curl "http://localhost/api/tag/{tag}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/tag/{tag}",
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
`GET api/tag/{tag}`

`HEAD api/tag/{tag}`


<!-- END_ea2909dfa1f07df5a1f5365024e334b2 -->
<!-- START_bfdb1ad681b7b80cc9d29577326d69d5 -->
## Update the specified resource in storage.

> Example request:

```bash
curl "http://localhost/api/tag/{tag}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/tag/{tag}",
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
`PUT api/tag/{tag}`

`PATCH api/tag/{tag}`


<!-- END_bfdb1ad681b7b80cc9d29577326d69d5 -->
<!-- START_cb7a2c6cb2d0ae999d407bbcc4e15e4e -->
## Remove the specified resource from storage.

> Example request:

```bash
curl "http://localhost/api/tag/{tag}" \
-H "Accept: application/json"
```

```javascript
var settings = {
    "async": true,
    "crossDomain": true,
    "url": "http://localhost/api/tag/{tag}",
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
`DELETE api/tag/{tag}`


<!-- END_cb7a2c6cb2d0ae999d407bbcc4e15e4e -->
