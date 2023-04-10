<?php

return [
    'open' => [
        'api_key'           => env('HUPUN_OPEN_KEY'),
        'api_secret'        => env('HUPUN_OPEN_SECRET'),
        'api_url'           => env('HUPUN_OPEN_URL', 'https://open-api.hupun.com/api'),
        'api_log_channel'   => env('HUPUN_OPEN_LOG_CHANNEL', 'single'),//日志通道， logging.php 中的通道
        'api_is_log_result' => env('HUPUN_OPEN_API_IS_LOG_RESULT', '0'),//是否记录结果
    ],
    'b2c'  => [
        'api_key'           => env('HUPUN_B2C_KEY'),
        'api_secret'        => env('HUPUN_B2C_SECRET'),
        'api_url'           => env('HUPUN_B2C_URL', 'https://erp-open.hupun.com/api'),
        'api_log_channel'   => env('HUPUN_B2C_LOG_CHANNEL', 'single'),//日志通道， logging.php 中的通道
        'api_is_log_result' => env('HUPUN_B2C_API_IS_LOG_RESULT', '0'),//是否记录结果
    ],

];