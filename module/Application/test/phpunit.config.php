<?php
/**
 * Created by PhpStorm.
 * User: Stanislav
 * Date: 24.11.2018
 * Time: 20:47
 */
return [
    'modules' => [
        'Application'
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            '../../../config/autoload/global.php'
        ],
        'module_paths' => array(
            'module',
            'vendor',
        ),
    ]
];
