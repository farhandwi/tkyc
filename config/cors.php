<?php

return [
    'paths' => ['api/*', 'docs/*', 'sanctum/csrf-cookie', 'swagger/*'],
    'allowed_methods' => ['*'],
    'allowed_origins' => ['http://localhost:3000', 'http://127.0.0.1:3000', 'http://localhost:8000','http://127.0.0.1:8000', 'http://localhost:4000','http://127.0.0.1:4000','https://login.microsoftonline.com'],
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true,
];