<?php
// 事件定义文件
return [
    'bind'      => [
        'kaoshistatus'=>'ksstatus',
    ],

    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
        'ksstatus' => [
            'app\listener\KaoshiStatus'
        ],
    ],
    'subscribe' => [
    ],
];
