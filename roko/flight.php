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
        Flight::exec(['Errors', 'err404']);
    });

    // Override internal errors
    if (defined('ENV') && ENV=="PROD") {
        error_reporting(0);
        Flight::map('error', function(){
            Flight::exec(['Errors', 'err500']);
        });
    }

    // Register Config Reader
    Flight::register('configReader', '\Roko\Core\ConfigReader', [APP_DIR.'/config']);
    Flight::map('cfg', function($paramPath, $default=null){
        return Flight::configReader()->get($paramPath, $default);
    });

    Flight::map('env', function(){
        return defined('ENV') ? ENV : null;
    });

    Flight::map('isEnv', function($env){
        return Flight::env() == $env;
    });

    // Initial configuration
    Flight::before('start', function(){
        try {
            // Load routes from config
            $routes = Flight::cfg('routes');
            if ($routes) {
                foreach($routes as $route=>$callback) {
                    Flight::route($route, $callback);
                }
            }

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

            $action = ($args[1] ?? 'index').'Action';

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

    Flight::register('session', '\Roko\Core\Session');
    Flight::register('cookie', '\Roko\Core\Cookie');

    // Map functions for easy access to global arrays

    Flight::map('_arr', function(array $arr, $varPath=null, $default=null){
        return \Roko\Helper\Arr::getArrValByVarPath($arr, $varPath, $default);
    });

    Flight::map('_get', function($varPath=null, $default=null){
        return Flight::_arr($_GET, $varPath, $default);
    });

    Flight::map('_post', function($varPath=null, $default=null){
        return Flight::_arr($_POST, $varPath, $default);
    });

    Flight::map('_request', function($varPath=null, $default=null){
        return Flight::_arr($_REQUEST, $varPath, $default);
    });

    Flight::map('_globals', function($varPath=null, $default=null){
        return Flight::_arr($GLOBALS, $varPath, $default);
    });

    Flight::map('_server', function($varPath=null, $default=null){
        return Flight::_arr($SERVER, $varPath, $default);
    });

    Flight::map('_cookie', function($varPath=null, $default=null){
        return Flight::_arr($_COOKIE, $varPath, $default);
    });

    Flight::map('_session', function($varPath=null, $default=null){
        return Flight::_arr($_SESSION, $varPath, $default);
    });

    Flight::map('_files', function($varPath=null, $default=null){
        return Flight::_arr($_FILES, $varPath, $default);
    });
    
    
    Flight::map('error', function($e){
        $getTraceString = function($exception){
            $rtn = "";
            $count = 0;
            foreach ($exception->getTrace() as $frame) {
                $args = "";
                if (isset($frame['args'])) {
                    $args = array();
                    foreach ($frame['args'] as $arg) {
                        if (is_string($arg)) {
                            $args[] = "'" . $arg . "'";
                        } elseif (is_array($arg)) {
                            $args[] = "Array";
                        } elseif (is_null($arg)) {
                            $args[] = 'NULL';
                        } elseif (is_bool($arg)) {
                            $args[] = ($arg) ? "true" : "false";
                        } elseif (is_object($arg)) {
                            $args[] = get_class($arg);
                        } elseif (is_resource($arg)) {
                            $args[] = get_resource_type($arg);
                        } else {
                            $args[] = $arg;
                        }
                    }
                    $args = join(", ", $args);
                }
                $current_file = "[internal function]";
                if(isset($frame['file']))
                {
                    $current_file = $frame['file'];
                }
                $current_line = "";
                if(isset($frame['line']))
                {
                    $current_line = $frame['line'];
                }
                $rtn .= sprintf( "#%s %s(%s): %s(%s)\n",
                        $count,
                        $current_file,
                        $current_line,
                        $frame['function'],
                        $args );
                $count++;
            }
            return $rtn;                
        };
        
        $msg = sprintf('<h1>500 Internal Server Error</h1>'.
            '<h3>%s (%s)</h3>'.
            '<pre>%s</pre>',
            $e->getMessage(),
            $e->getCode(),
            $getTraceString($e)
        );

        try {
            $this->response(false)
                ->status(500)
                ->write($msg)
                ->send();
        }
        catch (\Throwable $t) {
            exit($msg);
        }
        catch (\Exception $ex) {
            exit($msg);
        }
    });
