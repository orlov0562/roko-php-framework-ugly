<?php
    namespace App\Controller;

    abstract class Base_Backend_TemplateController extends Base_TemplateController {
        protected $theme = 'backend';

        protected function getLayoutSections(){
            $sections = parent::getLayoutSections();
            $sections['header_section'] = $this->partialRender('header');
            $sections['sidebar_section'] = $this->partialRender('sidebar');
            $sections['footer_section'] = $this->partialRender('footer');
            return $sections;
        }
    }