<?php
    namespace App\Controller;
    use Flight;

    abstract class Base_TemplateController {

        protected $theme = '';
        protected $layout = 'layout';
        protected $staticPages = [];

        protected $seo_title = '';
        protected $seo_description = '';
        protected $seo_keywords = '';
        protected $seo_author = '';
        protected $head_end_section = '';
        protected $body_start_section = '';
        protected $body_end_section = '';

        protected function render(array $data=[], $template=null, $ret = false) {
            if (!$template) {
                $template = Flight::get('controller').'/'.Flight::get('action');
            }
            $sections = $this->getLayoutSections();
            $sections['main_section'] = $this->partialRender($template, $data);
            $output = $this->partialRender($this->layout, $sections);
            if ($ret) {
                return $output;
            } else {
                echo $output;
            }
        }

        protected function getLayoutSections(){
            return [
                'seo_title' => $this->seo_title,
                'seo_description' => $this->seo_description,
                'seo_keywords' => $this->seo_keywords,
                'seo_author' => $this->seo_author,
                'head_end_section' => $this->head_end_section,
                'body_start_section' => $this->body_start_section,
                'body_end_section' => $this->body_end_section,
                'main_section' => '',
            ];
        }

        protected function partialRender($template, array $data=[]) {
            $template = (!empty($this->theme) ? $this->theme.'/' : '')
                        .$template
            ;
            ob_start();
            $data['_layout'] = $this;
            Flight::render($template, $data);
            return ob_get_clean();
        }

    }
