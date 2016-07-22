<?php

    namespace Roko\Helper\Widget;
    use Flight;
    use Roko\Helper\Html;

    class FlashWidget {

        public static function widget($group){
            $flashes = Flight::session()->flashes;
            if (!empty($flashes[$group])) {
                foreach ($flashes[$group] as $type=>$messages) {
                    foreach ($messages as $message) {
                        echo '<div class="alert alert-'.$type.' alert-dismissible" role="alert">';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo Html::esc($message);
                        echo '</div>';
                    }
                }
                $flashes[$group] = [];
                Flight::session()->flashes = $flashes;
            }
        }
        // allowed types: success, info, warning, danger
        public static function add(string $group, string $type, $newMessages) {

            $flashes = Flight::session()->flashes;

            if (!isset($flashes[$group][$type])) {
                $flashes[$group][$type] = [];
            }


            if (is_string($newMessages)) {
                $flashes[$group][$type][] = $newMessages;
            } else {
                $flashes[$group][$type] = array_merge($flashes[$group][$type], $newMessages);
            }

            Flight::session()->flashes = $flashes;
        }

        public static function clear($group='') {
            if ($group) {
                $flashes = Flight::session()->flashes;
                if (isset($flashes[$group])) {
                    unset($flashes[$group]);
                }
                Flight::session()->flashes = $flashes;
            } else {
                unset(Flight::session()->flashes);
            }
        }

    }