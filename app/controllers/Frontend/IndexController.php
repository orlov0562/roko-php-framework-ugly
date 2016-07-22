<?php
    namespace App\Controller;
    
    class Frontend_IndexController extends Base_Frontend_TemplateController {
        public function indexAction(){
            $this->seo_title = 'Roko PHP Framework';
            $this->render([
                'page_header'=> 'Hello world!',
                'page_content'=>'Hello world!'
            ], 'index/index');
        }

        public function aboutAction(){
            $this->seo_title = 'About Roko PHP Framework';
            $this->render([
                'page_header'=> 'About Roko PHP Framework',
            ]);
        }
    }
