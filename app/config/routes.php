<?php
    return [

        '/' => function(){
            return Flight::exec(['index','index'], 'Frontend');
        },

        '/@action' => function($action){
            return Flight::exec(['index',$action], 'Frontend');
        },

        '/@controller(/@action)' => function($controller, $action=null) {
            return Flight::exec([$controller, $action], 'Frontend');
        },


        '/admin(/@controller(/@action(/page/@page:[0-9]+)))' => function($controller=null, $action=null, $page=null) {
            return Flight::exec([$controller, $action, [$page]],'Backend');
        },

        '*' => function(){
            return Flight::exec(['Errors','err404']);
        },

    ];
