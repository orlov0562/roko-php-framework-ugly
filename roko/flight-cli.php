<?php

    // Log errors to the web server's error log file. (default: false)
    Flight::set('flight.log_errors', false);

    // Override the base url of the request. (default: null)
    Flight::set('flight.base_url', null);

    // Case sensitive matching for URLs. (default: false)
    Flight::set('flight.case_sensitive', false);

    // Allow Flight to handle all errors internally. (default: true)
    Flight::set('flight.handle_errors', true);

    // Directory containing view template files. (default: ./views)
    Flight::set('flight.views.path', APP_DIR.'/views');

    // View template file extension
    Flight::set('flight.log_errors', '.php');

    // Redefine 404 not found action
    Flight::map('notFound', function(){
        Flight::exec(['Errors', 'err404'], 'Cron');
    });

    Flight::map('env', function(){
        return defined('ENV') ? ENV : null;
    });

    Flight::map('isEnv', function($env){
        return Flight::env() == $env;
    });

    // Override internal errors
    if (defined('ENV') && ENV=="PROD") {
        error_reporting(0);
        Flight::map('error', function(){
            Flight::exec(['Errors', 'err500'], 'Cron');
        });
    }

    // Register Config Reader
    Flight::register('configReader', '\Roko\Core\ConfigReader', [APP_DIR.'/config']);
    Flight::map('cfg', function($paramPath, $default=null){
        return Flight::configReader()->get($paramPath, $default);
    });

    Flight::map('start', function() use ($argv) {
        $controller = $argv[1] ?? 'Index';
        $action = $argc[2] ?? 'index';
        $params = count($argv) > 3 ? array_slice($argv,3) : [];

        $res = Flight::exec([$controller, $action, $params], 'Cron');

        if (!is_null($res)) Flight::notFound();
    });

    // Initial configuration
    Flight::before('start', function(){
        try {
            // Initialize DB
            if (Flight::cfg('db.enabled')) {
                $connections = Flight::cfg('db.connections');
                foreach($connections as $connectionName=>$connectionSettings) {
                    if ($connectionSettings['autoload']) {
                        unset($connectionSettings['autoload']);
                        \ORM::configure($connectionSettings, null, $connectionName);
                    }
                }
            }
        } catch(Exception $ex) {
            if (defined('ENV') && ENV!="PROD") {
               Flight::error($ex);
            }
        }
    });

    // Register exec method to run controllers
    Flight::map('exec', function (array $args, string $controllerPrefix='', array $middleware=[]) {
            $controller = APP_NAMESPACE.'\\Controller\\'
                    .($controllerPrefix ? (ucwords(rtrim($controllerPrefix,'_'),'_').'_') : '')
                    .(isset($args[0]) ? ucwords($args[0],'_') : 'Index')
                    .'Controller'
            ;

            $action = (isset($args[1]) ? $args[1] : 'index').'Action';

            $params = isset($args[2])
                    ? ( is_array($args[2]) ? $args[2] : [$args[2]] )
                    : []
            ;

            if (!class_exists($controller)) {return true;}

            $obj = new $controller;

            if (!method_exists($obj, $action)) {return true;}

            Flight::set('controller', strtolower($args[0]??'index'));
            Flight::set('action', strtolower($args[1]??'index'));
            Flight::set('controller_prefix', strtolower(rtrim($controllerPrefix,'_')));

            foreach($middleware as $callback) {
                if (is_callable($callback)) {
                    call_user_func($callback);
                } elseif (method_exists($obj, $callback)) {
                    call_user_func([$obj, $callback]);
                }
            }

            if (method_exists($obj, 'before')) call_user_func([$obj, 'before']);

            call_user_func_array([$obj, $action], $params);

            if (method_exists($obj, 'after')) call_user_func([$obj, 'after']);

            return null;
    });

    Flight::map('_arr', function(array $arr, $varPath=null, $default=null){
        return \Roko\Helper\Arr::getArrValByVarPath($arr, $varPath, $default);
    });

    Flight::map('_argv', function($varPath=null, $default=null) use ($argv) {
        return Flight::_arr($argv, $varPath, $default);
    });