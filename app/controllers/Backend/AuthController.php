<?php
    namespace App\Controller;

    use Flight;
    use App\Helper\Auth;
    use App\Model\UserModel;
    use Roko\Helper\Form;
    use App\Helper\Recaptcha;
    use Roko\Core\DataModel;
    use Roko\Helper\Widget\FlashWidget;

    class Backend_AuthController extends Base_Backend_TemplateController {

        public function indexAction(){
            $this->seo_title = 'Roko PHP Framework';

            if (Auth::needToShowRecaptcha()) {
                $this->head_end_section .= Form::recaptchaScript();
            }

            $this->render([
                'page_header'=> 'Login',
            ], 'auth/index');
        }

        public function loginAction() {

            $formData = Flight::_post('formData');

            if ($formData) {

                $form = new DataModel($formData);

                $errors = [];

                if (Auth::needToShowRecaptcha() && !Recaptcha::validate()) {
                    $errors[] = 'Captcha not valid';
                }

                if (!$errors) {
                    $user = UserModel::getUser($form->username, $form->password);
                    if (!$user) {
                        $errors[] = 'Login or password incorrect';
                    } else {
                        Auth::resetErrors();
                        Auth::login($user, $form->remember);
                    }
                }

                if ($errors) {
                    FlashWidget::add('auth', 'danger', $errors);
                    Auth::incErrors();
                    Auth::logout();
                }
            }

        }

        public function logoutAction(){
            Auth::logout();
        }
    }