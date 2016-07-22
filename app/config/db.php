<?php

    return [
        'enabled' => true,
        'connections' => [
            \ORM::DEFAULT_CONNECTION => [
                'autoload' => false,
                'connection_string' => 'sqlite:'.ROOT_DIR.'/store/roko.db',
            ],
            'mysql' => [
                'autoload' => false,
                'connection_string' => 'mysql:host=localhost;dbname=roko',
                'username' => 'mysql',
                'password' => 'mysql',
            ],
            'sqlite' => [
                'autoload' => false,
                'connection_string' => 'sqlite:'.ROOT_DIR.'/store/roko.db',
            ],
        ],
    ];