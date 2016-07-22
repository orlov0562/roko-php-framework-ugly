<?php
    namespace App\Controller;
    use Flight;
    use Roko\Helper\Html;
    use Roko\Helper\Paginator;
    use App\Model\AuthErrorModel;

    class Backend_IndexController extends Base_Backend_AuthTemplateController {
        public function indexAction(){
            $this->seo_title = 'Roko PHP Framework';
            $this->render([
                'page_header'=> 'Admin panel',
                'page_content'=>'Hello, '.Html::esc(Flight::session()->user->name),
            ], 'index/index');
        }

        public function autherrAction($page=null){
            $this->seo_title = 'Auth Errors';

            $perPage = Flight::cfg('backend/lists.per_page');
            $page = $page ?? 1;

            if (Flight::_get('delete')) {
                $item = AuthErrorModel::get_orm()->find_one(Flight::_get('delete'));
                if ($item) $item->delete();
            }

            $orm = AuthErrorModel::get_orm();

            $pagination = Paginator::getPaginationInfo($orm, $perPage, $page);
            if ($pagination->error) {
                if (Flight::isEnv('PROD')) {
                    Flight::notFound();
                } else {
                    throw \Exception($pagination->error);
                }
            }
            $orm->offset($pagination->offset)->limit($pagination->limit);

            $data = $orm->find_array();

            $this->render([
                'page_header' => 'Auth errors',
                'data' => $data,
                'pagination' => $pagination,
            ], 'index/autherr');
        }
    }