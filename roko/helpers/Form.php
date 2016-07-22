<?php
    namespace Roko\Helper;

    class Form {
        public static function open(string $url='', array $attr=[]):string {
            $attr['action'] = Url::url($url);
            return Html::tag('form','', $attr, false);
        }

        public static function close():string {
            return '</form>';
        }

        public static function text(string $name='', string $value='', array $attr=[]):string {
            $attr['type'] = 'text';
            if ($name) $attr['name'] = 'formData['.$name.']';
            $attr['value'] = Html::esc($value);
            return Html::tag('input','', $attr, false);
        }

        public static function password(string $name='', array $attr=[]):string {
            $attr['type'] = 'password';
            if ($name) $attr['name'] = 'formData['.$name.']';
            return Html::tag('input','', $attr, false);
        }

        public static function textarea(string $name='', string $value='', array $attr=[]):string {
            if ($name) $attr['name'] = 'formData['.$name.']';
            return Html::tag('textarea', Html::esc($value), $attr);
        }

        public static function label(string $text='', string $for='', array $attr=[], bool $esc=true):string {
            if ($for) $attr['for'] = $for;
            return Html::tag('label', $text, $attr, $esc);
        }

        public static function button(string $name='', string $value='', array $attr=[]):string {
            $attr['type'] = 'button';
            if ($name) $attr['name'] = 'formData['.$name.']';
            $attr['value'] = Html::esc($value);
            return Html::tag('input','', $attr, false);
        }

        public static function submit(string $name='', string $value='', array $attr=[]):string {
            $attr['type'] = 'submit';
            if ($name) $attr['name'] = 'formData['.$name.']';
            $attr['value'] = Html::esc($value);
            return Html::tag('input','', $attr, false);
        }

        public static function checkbox(string $name='', string $value='', bool $checked=false, array $attr=[]):string {
            $attr['type'] = 'checkbox';
            if ($name) $attr['name'] = 'formData['.$name.']';
            if ($checked) $attr['checked'] = 'checked';
            $attr['value'] = Html::esc($value);
            return Html::tag('input','', $attr, false);
        }

        public static function radiobox(string $name='', string $value='', bool $checked=false, array $attr=[]):string {
            $attr['type'] = 'radiobox';
            if ($name) $attr['name'] = 'formData['.$name.']';
            if ($checked) $attr['checked'] = 'checked';
            $attr['value'] = Html::esc($value);
            return Html::tag('input','', $attr, false);
        }

        public static function select(string $name='', array $items=[], string $value='', array $attr=[]):string {
            if ($name) $attr['name'] = 'formData['.$name.']';
            $options = '';
            foreach($items as $itemValue=>$itemText) {
                $attr['value'] = $value;
                if ($itemValue==$value) {$attr['selected'] = 'selected';}
                $options.=Html::tag('option', $itemText, $attr);
            }
            return Html::tag('select',$options, $attr);
        }

        public static function recaptcha(string $sitekey, array $attr=[]):string {
            $attr['class'] = 'g-recaptcha '.trim($attr['class']??'');
            $attr['data-sitekey'] = $sitekey;
            return Html::tag('div','', $attr);
        }

        public static function recaptchaScript():string{
            return '<script src="https://www.google.com/recaptcha/api.js"></script>';
        }

    }