<?php

namespace Roko\Helper;

class BS { // Bootstrap

    public static function panelStart($header=false, $class='default') {
        if (is_array($header)) {
            $text = $header[0] ?? false;
            $icon = $header[1] ?? false;
            $esc = $header[2] ?? true;
        } else {
            $text = $header;
            $icon = false;
            $esc = true;
        }
        $html = '<div class="panel panel-'.$class.'">';
        if ($text) {
            if ($esc) {$text = Html::esc($text);}
            $html .='<div class="panel-heading"><h3 class="panel-title">'.Html::appendIcon($icon, $text).'</h3></div>';
        }
        $html .= '<div class="panel-body">';
        return $html;
    }

    public static function panelEnd($footer=false) {
        if (is_array($footer)) {
            $text = $footer[0] ?? false;
            $icon = $footer[1] ?? false;
            $esc = $footer[2] ?? true;
        } else {
            $text = $footer;
            $icon = false;
            $esc = true;
        }

        $html = '</div>';
        if ($text) {
            if ($esc) $text = Html::esc($text);
            $html .='<div class="panel-footer">'.Html::appendIcon($icon, $text).'</div>';
        }
        $html .= '</div>';
        return $html;
    }

    public static function table(array $headers, array $rows, array $attr=[]) {
        $attr['class'] = 'table '.trim($attr['class']??'');

        $table_html = '';

        $th_html = '';
        foreach($headers as $header) {
            $th_html .= Html::tag('th', Html::esc($header));
        }
        $thead_html = Html::tag('tr', $th_html);

        $tbody_html = '';
        foreach ($rows as $row) {
            $row_html = '';
            foreach($row as $col) {
                $td = is_callable($col)
                      ? call_user_func($col)
                      : Html::esc($col)
                ;
                $row_html .= Html::tag('td', $td);
            }
            $tbody_html .= Html::tag('tr', $row_html);
        }

        $table_html .= Html::tag('thead', $thead_html);
        $table_html .= Html::tag('tbody', $tbody_html);

        return Html::tag('table', $table_html, $attr);
    }

    public static function pagination(\stdClass $pagination, $baseUrl, array $attr=[], $total='records', $from='from') {

        if (!empty($pagination->error)) return '';

        $attr['class'] = 'pull-right '.trim($attr['class']??'');

        $nav = [];
        $nav[] = Html::tag('span', $pagination->total.' '.$total).' &nbsp; ';

        $class = 'btn btn-default btn-sm'.($pagination->current == 1 ? ' disabled':'');
        $nav[] = Html::a($baseUrl, '&laquo;', ['class'=>$class], false);

        $url = $baseUrl . (($pagination->current - 1) > 1 ? '/page/'.($pagination->current - 1) : '');
        $class = 'btn btn-default btn-sm'.($pagination->current == 1 ? ' disabled':'');
        $nav[] = Html::a($url, '&lsaquo;', ['class'=>$class], false);

        $nav[] = Html::tag('span', $pagination->current.' '.$from.' '.$pagination->pages);

        $url = $baseUrl . (($pagination->current + 1) <= $pagination->pages ? '/page/'.($pagination->current+1) : '');
        $class = 'btn btn-default btn-sm'.(($pagination->current+1) > $pagination->pages ? ' disabled':'');
        $nav[] = Html::a($url, '&rsaquo;', ['class'=>$class], false);

        $url = $baseUrl . '/page/'.$pagination->pages;
        $class = 'btn btn-default btn-sm'.($pagination->current >= $pagination->pages ? ' disabled':'');
        $nav[] = Html::a($url, '&raquo;', ['class'=>$class], false);

        return Html::tag('nav', implode(' ', $nav), $attr);
    }

}