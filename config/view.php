<?php

return [
    'paths' => [
        resource_path('views'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | Vercel 的執行環境是唯讀的，storage/framework/views 不能寫入。
    | 若 storage 可寫就用原路徑，否則改寫到 /tmp（唯寫目錄）。
    |
    */
    'compiled' => env('VIEW_COMPILED_PATH', is_writable(storage_path('framework/views'))
        ? storage_path('framework/views')
        : (realpath(sys_get_temp_dir()) ?: sys_get_temp_dir())),
];
