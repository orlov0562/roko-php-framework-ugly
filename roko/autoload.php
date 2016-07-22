<?php

    spl_autoload_register(function ($className) {
        $map = [
            '^Roko\\\\Core\\\\(.+)$' => ROKO_DIR.'/core/',
            '^Roko\\\\Helper\\\\(.+)$' => ROKO_DIR.'/helpers/',
            '^'.APP_NAMESPACE.'\\\\Controller\\\\(.+)$' => APP_DIR.'/controllers/',
            '^'.APP_NAMESPACE.'\\\\Model\\\\(.+)$' => APP_DIR.'/models/',
            '^'.APP_NAMESPACE.'\\\\Helper\\\\(.+)$' => APP_DIR.'/helpers/',
        ];

        foreach ($map as $mask=>$path) {
            if (preg_match('~'.$mask.'~', $className)) {
                $filePath = $className;
                $filePath = str_replace('_','/',$filePath);
                $filePath = preg_replace('~'.$mask.'~', $path.'$1', $filePath);
                $filePath = str_replace('\\','/',$filePath);
                $filePath .= '.php';
                if (file_exists($filePath)) {
                    require_once $filePath;
                    break;
                }
            }
        }
    });