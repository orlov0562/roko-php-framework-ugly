<?php

namespace Roko\Helper;
use ORM;

class Paginator {

    public static function getPaginationInfo(ORM $orm, $perPage, $page) {
        $error = null;

        $total_items = (int) $orm->count();
        $total_pages = ceil($total_items / $perPage);

        if ($page<1 OR ($page-1) > $total_pages) {
            $error = 'Page not found';
        }

        $from = $perPage * ($page - 1);

        return (object) [
            'total' => $total_items,
            'pages' => $total_pages,
            'offset' => $from,
            'limit' => $perPage,
            'current' => $page,
            'per_page' => $perPage,
            'error' => $error,
        ];
    }
}

