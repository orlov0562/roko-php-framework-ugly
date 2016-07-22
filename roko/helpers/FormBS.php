<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Roko\Helper;

/**
 * Description of FormBS
 *
 * @author vitto
 */
class FormBS
{
      public static function open(string $url='', array $attr=[]):string {
            return Form::open($url, $attr);
        }

        public static function close():string{
            return Form::close();
        }

        public static function group(array $items=[], string $help=''):string {
            $html = '';
            $html .= '<div class="form-group">'.PHP_EOL;
            $html .= implode($items).PHP_EOL;
            if ($help) { $html .= '<p class="help-block">'.$help.'</p>'.PHP_EOL; }
            $html .= '</div>'.PHP_EOL;
            return $html;
        }

        public static function text(string $labelText='', string $name='', string $value='', array $attr=[]):string {
            $label = Form::label($labelText, $attr['id'] ?? '');
            $attr['class'] = 'form-control '.trim($attr['class']??'');
            $element = Form::text($name, $value, $attr);
            return self::group([$label, $element]);
        }

        public static function password(string $labelText='', string $name='', array $attr=[]):string {
            $label = Form::label($labelText, $attr['id'] ?? '');
            $attr['class'] = 'form-control '.trim($attr['class']??'');
            $element = Form::password($name, $attr);
            return self::group([$label, $element]);
        }

        public static function textarea(string $labelText='', string $name='', string $value='', array $attr=[]):string {
            $label = Form::label($labelText, $attr['id'] ?? '');
            $attr['class'] = 'form-control '.trim($attr['class']??'');
            $element = Form::textarea($name, $value, $attr);
            return self::group([$label, $element]);
        }

        public static function button(string $name='', string $value='', array $attr=[]):string {
            $attr['class'] = 'btn btn-default '.trim($attr['class']??'');
            return Form::button($name, $value, $attr);
        }

        public static function submit(string $value='', string $name='submit', array $attr=[]):string {
            $attr['class'] = 'btn btn-primary '.trim($attr['class']??'');
            return Form::submit($name, $value, $attr);
        }

        public static function checkbox(string $labelText='', string $name='', string $value='', bool $checked=false, array $attr=[]):string {
            $labelContent = Form::checkbox($name, $value, $checked, $attr);
            $labelContent .= ' '.Html::esc($labelText);
            $label = Form::label($labelContent);
            return self::group(['<div class="checkbox">'.$label.'</div>']);
        }

        public static function radiobox(string $labelText='', string $name='', string $value='', bool $checked=false, array $attr=[]):string {
            $labelContent = Form::radiobox($name, $value, $checked, $attr);
            $labelContent .= ' '.Html::esc($labelText);
            $label = Form::label($labelContent);
            return self::group(['<div class="checkbox">'.$label.'</div>']);
        }

        public static function select(string $labelText='',string $name='', array $items=[], string $value='', array $attr=[]):string {
            $attr['name'] = $name;
            $label = Form::label($labelText, $attr['id'] ?? '');
            $attr['class'] = 'form-control '.trim($attr['class']??'');
            $element = Form::select($name, $items, $value, $attr);
            return self::group([$label, $element]);
        }

        public static function recaptcha(string $labelText='', string $sitekey='', array $attr=[]):string {
            $label = Form::label($labelText, $attr['id'] ?? '');
            $element = Form::recaptcha($sitekey, $attr);
            return self::group([$label, $element]);
        }

        public static function recaptchaScript():string{
            return Form::recaptchaScript();
        }
}
