<?php
// 事件定义文件
return [
    'bind'      => [
        'myevent'=>'app\event\MyEvent',
    ],

    'listen'    => [
        'AppInit'  => [],
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
        'kslu' => [
            '\app\listener\KaoshiLuru'
        ],
        'tjlog' => [
            '\app\listener\TongjiLog'
        ],
        'ksjs' => [
            '\app\listener\KaoshiJieShu'
        ],
    ],
    'subscribe' => [
    ],
];
