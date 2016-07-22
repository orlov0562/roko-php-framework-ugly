<?php
    use Roko\Helper\Html;
    use Roko\Helper\BS;
?>
<article>
    <header><h1 class="page-header"><?=$page_header??''?></h1></header>

    <p>Roko PHP Framework - very light and fast MVC PHP Framework based on next components:</p>

    <div class="well">
        <div class="row">
            <div class="col-md-6">
                <strong>Backend</strong>
                <?=Html::menu([
                    [['http://flightphp.com/','Flight microframework',['target'=>'_blank']]],
                    [['https://idiorm.readthedocs.io/en/latest/','Idiorm ORM',['target'=>'_blank']]],
                ])?>
            </div>
            <div class="col-md-6">
                <strong>Frontend</strong>
                <?=Html::menu([
                    [['http://getbootstrap.com/','Bootstrap',['target'=>'_blank']]],
                    [['http://jquery.com/','jQuery',['target'=>'_blank']]],
                    [['http://fontawesome.io/','Fontawesome',['target'=>'_blank']]],
                    [['https://github.com/aFarkas/html5shiv/','html5shiv',['target'=>'_blank']]],
                    [['https://github.com/scottjehl/Respond','Respond',['target'=>'_blank']]],
                ])?>
            </div>
        </div>
    </div>

    <p>I have created it because all other frameworks (Yii, Laravel, Symfony ..) is very huge
        and contains a lot of logic that no need in small or MVP projects. From the other side
        micro-frameworks (Flight, Slim, Silex, Lumen ..) doesn't contains MVC, ORM and frontend
        components from the box.</p>

    <p>At some point I decide to join all components that I need into one skeleton application.
        As the result I got Roko PHP Framework.
    </p>

<br>

<h2>Key features that Roko can</h2>

<hr>

<?=BS::panelStart('Clear directory structure')?>
<pre>
../app/config/..
../app/controllers/..
../app/models/..
../app/helpers/..
../app/views/..
</pre>
<?=BS::panelEnd()?>

<br>

<?=BS::panelStart('Clear classes, configs and views autoloading')?>
<pre>
\App\IndexController => /app/controllers/IndexController.php

\App\Base_IndexController => /app/controllers/Base/IndexController.php

----

\App\Helper\Html => /app/helpers/Html.php

----

Flight::cfg('db.host') => /app/config/db.php [ host=>localhost ]

----

Flight::exec(['index','hello']) =>
    /app/controllers/IndexController.php [ helloAction() ]

Flight::exec(['index','hello'], 'Backend') =>
    /app/controllers/Backend/IndexController.php [ helloAction() ]

----

($theme='frontend'; $layout='layout')

$this->render(['var'=>$val], 'index/index') =>
    /app/views/frontend/layout.php <-
        /app/views/frontend/index/index.php <-
            $var

$this->render(['var'=>$val]) =>
    /app/views/frontend/layout.php <-
        /app/views/frontend/@controller/@action.php <-
            $var
</pre>
<?=BS::panelEnd()?>

<br>

<?=BS::panelStart('Simple but handy routing')?>
<p>The simpliest router is</p>
<pre>'/' => function(){ echo 'Hello world'; }</pre>
<p>as you can see it's the same behavior as in Flight PHP. But let's use MVC:</p>
<pre>'/' => function(){ return Flight::exec([]); }</pre>
<p>it's the same as next</p>
<pre>'/' => function(){ return Flight::exec(['index','index']); }</pre>
<p>I think you no need explanation to understand that in example above Roko will call
<code>App\IndexController::indexAction</code></p>
<p>Let's do something more difficult</p>
<pre>
'/admin(/@controller(/@action))' => function($controller=null, $action=null) {
    return Flight::exec(
        [$controller, $action],
        'Backend',
        [function(){echo 'middleware';}]
    );
},
</pre>

<p>This route will match all urls that starts from <code>/admin/</code>, then it try to get controller and action.
If controller or action not found it will use default <code>IndexController</code> and <code>indexAction</code>
accordingly.
</p>

<p>The next parameter <code>Backend</code> is controller prefix, so it will call
    <code>App\Backend_IndexController::IndexAction</code>.
    It's very usefull when you want to divide backend and frontend logic into separate folders, eg:
</p>
<pre>
../app/controllers/Backend/IndexController.php
../app/controllers/Frontend/IndexController.php
</pre>
<p>You can do the same thing by appends right to controller (<code>'Backend_'.$controller</code>),
    but I like keep prefix separately</p>

<p>Next thing it's array of middleware callbacks where you can place any additional logic
    (authentication for example)</p>

<pre>[function(){echo 'middleware';}]</pre>

<p>Every controller also can contain <code>before()</code> and <code>after()</code> methods that will auto
    executed after middleware and before/after controller action. It's also right point to make Base controller
    for protected areas (admin panel, dashboards, etc).
</p>

For other examples of route definitions see <?=Html::a('http://flightphp.com/learn#routing','FlightPHP help',['target'=>'_blank'])?>
<?=BS::panelEnd()?>

<br>

<?=BS::panelStart('Easy access and creation of configuration files ')?>
To create conf files, just create file in config folder, ex: <strong>admin.php</strong>
<pre>
return [
    'backend' => [
        'user' => 'Roko',
        'pass' => 'roko',
        'role' => 'admin',
    ],
];
</pre>
Then in any place of code, from controller to views, you can call it in this way:
<pre>
Flight::cfg('admin'); // return full array
Flight::cfg('admin.backend.user'); // return "Roko"
</pre>
<?=BS::panelEnd()?>

<br>

<?=BS::panelStart('Easy access to global variables')?>
<p>You can access any global variables in easy and "no warnings" way.</p>
<p>For example you have next $_GET array</p>

<pre>
[
    'user' => [
        'name' => 'Adam',
    ],
    'age' => 16,
];
</pre>
<p>You can access to values in this simple way:</p>
<pre>
Flight::_get('user.name'); // return "Adam"
Flight::_get('age'); // return "16"
Flight::_get('sex','male'); // return "male"
Flight::_get('undefined'); // return "null"
Flight::_get(); // return $_GET array
</pre>
<p>It works for all global variables: GET, POST, SESSION, COOKIE, SERVER and so on</p>
<?=BS::panelEnd()?>

<br>

<?=BS::panelStart('Easy get/set of session and cookies')?>
<p>You can easly set session and cookies. Just looks to the code</p>
<pre>
// no need to start session, framework make it automaticaly
Flight::session()->message = 'hello world'; // save to session
echo Flight::session()->message; // retrieve from session
unset(Flight::session()->message); // delete from session
</pre>
<p>Same way for cookies:</p>
<pre>
Flight::cookie()->message = 'hello world'; // save to session
echo Flight::cookie()->message; // retrieve from session
unset(Flight::cookie()->message); // delete from session
</pre>
<p>if you want to specify cookie expiration or domain you can use next functions:</p>
<pre>
Flight::cookie()->set('message', 'hello world', 60, '/path/to');
Flight::cookie()->del('message', '/path/to');
</pre>
<?=BS::panelEnd()?>

<br>

<h2>Roko has from the box</h2>

<hr>
<ul>
    <li>All functionality that Flight PHP has</li>
    <li>Url rewrites</li>
    <li>Simple routing</li>
    <li>MVC</li>
    <li>Cron</li>
    <li>Idiorm ORM for databases</li>
    <li>jQuery, Bootstrap, Fontawesome</li>
    <li>Layouts and templates</li>
    <li>Frontend and protected backend skeleton</li>
</ul>

<br>

<h2>What is "Roko" means?</h2>
<hr>
<p>I don't know yet. Just four chars from the mind :)</p>

<br>

<h2>Author</h2>

<hr>
<p>Vitaliy Orlov | orlov.cv.ua</p>

</article>
