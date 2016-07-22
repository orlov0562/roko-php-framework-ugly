<?php
    namespace App\Controller;
    use Flight;

    class ErrorsController {
        public function err404Action(){
            Flight::halt(404, 'Errors Controller :: 404 not found<br>');
        }

        public function err500Action(){
            Flight::halt(500, 'Errors Controller :: 500 Internal error<br>');
        }
    }
