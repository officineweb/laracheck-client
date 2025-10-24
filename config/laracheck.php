<?php

return [
    'api_key' => env('LARACHECK_KEY'),
    'endpoint' => env('LARACHECK_URL') ? env('LARACHECK_URL').'/api/exceptions' : null,
];
