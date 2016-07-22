<?php
    use Roko\Helper\Url;
    use Roko\Helper\Html;
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?=Html::esc($seo_title??'')?></title>
    <meta name=description content="<?=Html::esc($seo_description??'')?>">
    <meta name=keywords content="<?=Html::esc($seo_keywords??'')?>">
    <meta name=author content="<?=Html::esc($seo_author??'')?>">

    <link rel="stylesheet" href="<?=Url::bower('bootstrap/dist/css/bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=Url::bower('bootstrap/dist/css/bootstrap-theme.min.css')?>">

    <link rel="stylesheet" href="<?=Url::bower('font-awesome/css/font-awesome.min.css')?>">

    <link rel="stylesheet" href="<?=Url::dist('orl-scroller/scroller.css')?>">

    <link rel="stylesheet" href="<?=Url::assets('frontend/css/style.css')?>">

    <!--[if lt IE 9]>
      <script src="<?=Url::bower('html5shiv/dist/html5shiv.min.js')?>"></script>
      <script src="<?=Url::bower('respond/dest/respond.min.js')?>"></script>
    <![endif]-->

    <?=$head_end_section??''?>
</head>
<body>
    <?=$body_start_section??''?>
    <div class="container container-header">
        <div class="row">
            <div class="col-md-12">
                <header class="main">
                    <?=$header_section??''?>
                </header>
            </div>
        </div> <!-- .row -->
    </div> <!-- .container -->

    <div class="container container-body">
        <div class="row">
            <div class="col-md-8">
                <main>
                    <?=$main_section??''?>
                </main>
            </div>
            <div class="col-md-4">
                <aside>
                    <?=$sidebar_section??''?>
                </aside>
            </div>
        </div> <!-- .row -->
    </div> <!-- .container -->

    <div class="container container-footer">
        <div class="row">
            <div class="col-md-12">
                <footer class="main">
                    <?=$footer_section??''?>
                </footer>
            </div>
        </div> <!-- .row -->
    </div> <!-- .container -->

    <a id="page-scroller" title="Scroll up"></a>

    <script src="<?=Url::bower('jquery/dist/jquery.min.js')?>"></script>
    <script src="<?=Url::bower('bootstrap/dist/js/bootstrap.min.js')?>"></script>
    <script src="<?=Url::dist('orl-scroller/scroller.js')?>"></script>

    <?=$body_end_section??''?>
</body>
</html>