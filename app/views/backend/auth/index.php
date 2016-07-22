<?php
    use Roko\Helper\FormBS;
    use Roko\Helper\Widget\FlashWidget;
    use App\Helper\Auth;
    use App\Helper\Recaptcha;
?>
<article>
    <header><h1 class="page-header"><?=$page_header??''?></h1></header>

    <?=FlashWidget::widget('auth')?>

    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <?=FormBS::open('admin/auth/login',['method'=>'post'])?>
            <?=FormBS::text('User name', 'username', '', ['placeholder'=>'User name'])?>
            <?=FormBS::password('Password', 'password')?>
            <?=FormBS::checkbox('Remember me', 'remember', 'yes')?>
            <?=Auth::needToShowRecaptcha() ? Recaptcha::render() :'' ?>
            <?=FormBS::submit('Log in')?>
            <?=FormBS::close()?>
        </div>
        <div class="col-md-3"></div>
    </div>

</article>