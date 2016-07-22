<?php
    namespace Roko\Helper;

    class Html {

        public static function esc($str){
            return htmlspecialchars($str, ENT_QUOTES);
        }

        public static function tag($name, $content='', array $attr=[],  $closed=true) {
            $html = '<'.$name;
            if ($attr) {
                foreach($attr as $attrName=>$attrValue) {
                    $html .= ' '.$attrName.'="'.trim($attrValue).'"';
                }
            }
            $html .= '>';
            if ($closed) {
                $html .= $content;
                $html .= '</'.$name.'>'.PHP_EOL;
            }
            return $html;
        }

        /**
         *
         * @param string $url
         * @param string $content
         * @param array $attr
         * @param type $escape
         * @return type
         *
         * In $attr you can pass additional params:
         * - [icon => home] appends font awesome icon before link content: "<span class="fa fa-home"></span> $content"
         */

        public static function a(string $url, string $content, array $attr=[], $escape=true) {
            if ($escape) {
                $content = Html::esc($content);
            }

            if (!empty($attr['icon'])) {
                $content = self::appendIcon($attr['icon'], $content);
                unset($attr['icon']);
            }

            $attr['href'] = Url::url($url);
            return self::tag('a', $content, $attr);
        }

        public static function appendIcon($icon, $content) {
            if ($icon) {
                $content = self::tag('span','',['class'=>'fa fa-'.$icon]).' '.$content;
            }
            return $content;
        }

        /**
         * Menu builder
         * @param array $items
         * @param array $attr
         * @return type
         *
         * $items structure:
         * [
         *    [[string $linkUrl, string $linkContent, array $linkAttr=[], $escapeContent=true], bool $isActiveItem=false, array $itemAttr=[])],
         *    ..
         * ]
         *
         */
        public static function menu(array $items, array $menuAttr=[]) {

            $ulContent = '';
            foreach ($items as $item) {
                $a_url = $item[0][0] ?? '';
                $a_content = $item[0][1] ?? '';
                $a_attr = $item[0][2] ?? [];
                $a_esc = $item[0][3] ?? true;

                $a = self::a($a_url, $a_content, $a_attr, $a_esc);

                $li_active = $item[1] ?? false;
                $li_attr = $item[2] ?? [];
                if ($li_active) {
                    $li_attr['class'] = ($li_attr['class'] ?? '').' active';
                }

                $ulContent .= self::tag('li', $a, $li_attr);
            }

            return self::tag('ul', $ulContent, $menuAttr);
        }
    }

