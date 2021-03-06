<?php

    return [
        'enabled' => true,
        'connections' => [
            \ORM::DEFAULT_CONNECTION => [
                'autoload' => true,
                'connection_string' => 'sqlite:'.ROOT_DIR.'/store/roko.sqlite',
            ],
            'mysql' => [
                'autoload' => false,
                'connection_string' => 'mysql:host=localhost;dbname=roko',
                'username' => 'mysql',
                'password' => 'mysql',
                'driver_options' => [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
            ],
            'sqlite' => [
                'autoload' => false,
                'connection_string' => 'sqlite:'.ROOT_DIR.'/store/roko.sqlite',
            ],
        ],
    ];
