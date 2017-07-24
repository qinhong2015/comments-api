# Comments basic api demonstration

Demo: click this link [Demo](http://comments.qineddiehong.info).

Simple CRUD API demonstration for comment object

Features: [Redis Cache](https://redis.io/), [JWT token authentication](https://jwt.io/)

## Frontend

Build on top of Vue.js version 2.0

Static JWT token and http request root can be set in [main.js](https://github.com/qinhong2015/comments-api/blob/master/view/src/main.js)

```js
Vue.http.options.root = 'url'
Vue.http.headers.common['Authorization'] = 'Bearer jwt_token'
```

Installation
```
cd view
npm install
npm run build
```

Additional package used: [vue-resource](https://github.com/pagekit/vue-resource),[vue-boostrap](https://github.com/bootstrap-vue/bootstrap-vue)

## Backend

Build on top of Lumen 5.4

Additional package used: [Lumen CORS](https://github.com/digiaonline/lumen-cors), [php-jwt](https://github.com/firebase/php-jwt),
[predis](https://github.com/nrk/predis), [illuminate-redis](https://github.com/illuminate/redis)

Installation

```
cd api
cp .env.example .env (update env variable if necessary, if you changed APP_KEY then you must generate a new jwt token for frontend as well)
composer install
php artisan migrate
```

## Jwt authentication(HS256)

1. Generate a Jwt token (a simple static token that does not expire for demostration purpose) signed with our APP_KEY which contains user permission data  

```
php artisan generate:token
```

user permission can be changed at [GenerateTokenCommand](https://github.com/qinhong2015/comments-api/blob/master/api/app/Console/Commands/GenerateToken.php)

```php
$data = [
    'iat'  => $issuedAt,         
    'iss'  => $serverName,       
    'nbf'  => $notBefore,        
    'data' => [                  // user permission data  
        'get' => true,
        'put' => true,
        'post' => true,
        'delete' => true
    ]
];
```

2. Set jwt token in vue client: [main.js](https://github.com/qinhong2015/comments-api/blob/master/view/src/main.js)

```js
Vue.http.headers.common['Authorization'] = 'Bearer jwt_token'
```

3. Jwt token will be intercepted in auth middleware, then we will proceed to decode the jwt with our APP_KEY and retrieve user permission data from the token. Please see [AuthServiceProvider.php](https://github.com/qinhong2015/comments-api/blob/master/api/app/Providers/AuthServiceProvider.php).

```php
$token = JWT::decode($jwt, $secretKey, array('HS256'));
```

## Cache eviction with Redis

Please see in [Comment Model](https://github.com/qinhong2015/comments-api/blob/master/api/app/Model/Comments.php)

- make sure CACHE_DRIVER is set use redis in .env
- comments collection cache with cache key 'comment'
- single comment cache with cache key "comment:$commentId"
- expire in a day

GetComment:
- if comment data is cached then return cached data.
- if comment data is not cached then query database for data, cache the data and return database results. 

CreateComment:
- remove comments collection cache
- set created comment cache

UpdateComment
- update updated comment cache
- remove comments collection cache

DeleteComment
- remove deleted comment cache
- remove comments collection cache



