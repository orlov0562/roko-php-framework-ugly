<?php
    namespace App\Controller;

    class Cron_ErrorsController {
        public function err404Action(){
            echo '404 not found'.PHP_EOL;
        }

        public function err500Action(){
            echo '500 Internal Error'.PHP_EOL;
        }
    }
