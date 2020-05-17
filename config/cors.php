<?php
// 这样跨域请求时，才能返回 header 头为 Authorization 的内容，否则在刷新用户 token 时不会返回刷新后的 token
return [
    'allow-credentials'  => env('CORS_ALLOW_CREDENTIAILS', false), // set "Access-Control-Allow-Credentials" 👉 string "false" or "true".
    'allow-headers'      => ['*'], // ex: Content-Type, Accept, X-Requested-With
    'expose-headers'     => [],
    'origins'            => ['*'], // ex: http://localhost
    'methods'            => ['*'], // ex: GET, POST, PUT, PATCH, DELETE
    'max-age'            => env('CORS_ACCESS_CONTROL_MAX_AGE', 0),
        'expose-headers'     => ['Authorization'],
    'laravel'            => [
        'allow-route-prefix' => env('CORS_LARAVEL_ALLOW_ROUTE_PREFIX', '*'), // The prefix is using \Illumante\Http\Request::is method. 👉
        'route-group-mode'   => env('CORS_LARAVEL_ROUTE_GROUP_MODE', false),
    ],
];
