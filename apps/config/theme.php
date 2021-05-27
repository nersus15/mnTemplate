
<?php
// Resource group "main"
$config['themes']['main']['js'] = array(
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/jquery/jquery-3.3.1.min.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/jquery/jquery.form.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/bootstrap/js/popper.min.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/bootstrap/js/bootstrap.min.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/bootstrap/js/bootstrap.bundle.min.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/bootstrap-notify/bootstrap-notify.min.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/jquery-validation/dist/jquery.validate.min.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/moment/moment.min.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/kamscore/js/Kamscore.js'),
    // array('pos' => 'body:end', 'src' => STATIC_PATH . 'js/main.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/kamscore/js/uihelper.js'),
);

$config['themes']['main']['css'] = array(
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/bootstrap/css/bootstrap.min.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/fontawesome/css/all.min.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/dore/icon/iconsmind/style.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/dore/icon/simple-line-icons/css/simple-line-icons.css')
);

// ICON ONLY
$config['themes']['icons']['css'] = array(
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/bootstrap/css/bootstrap.min.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/fontawesome/css/all.min.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/dore/icon/iconsmind/style.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/dore/icon/simple-line-icons/css/simple-line-icons.css')
);

// Dore themes
$config['themes']['dore']['css'] = array(
    array('pos' => 'head', 'src' => 'https://keuangan.kamscode.tech/public/assets/vendor/dore/css/dore.light.green.min.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/dore/css/main.css')
);
$config['themes']['dore']['js'] = array(
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/dore/js/script.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/dore/js/dore.script.js'),
);

// Landing Page

$config['themes']['landing']['css'] = array(
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/bootstrap/css/bootstrap-stars.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/bootstrap/css/bootstrap.min.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/owl/css/owl-carousel.min.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/bootstrap/css/bootstrap-stars.css'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/dore/css/main.css'),
);

$config['themes']['landing']['js'] = array(
    array('pos' => 'body:end', 'src' => STATIC_PATH . 'asset/vendor/owl/js/owl-carousel.js'),
    array('pos' => 'body:end', 'src' => STATIC_PATH . 'asset/vendor/landing-page/js/headroom.min.js'),
    array('pos' => 'body:end', 'src' => STATIC_PATH . 'asset/vendor/landing-page/js/jQuery.headroom.js'),
    array('pos' => 'body:end', 'src' => STATIC_PATH . 'asset/vendor/landing-page/js/jquery.scrollTo.min.js'),
    array('pos' => 'body:end', 'src' => STATIC_PATH . 'asset/vendor/landing-page/js/jquery.autoellipsis.js'),
    array('pos' => 'body:end', 'src' => STATIC_PATH . 'asset/vendor/dore/js/landing.script.js'),
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/dore/js/script.js'),

);

// FORM
$config['themes']['form']['css'] = array(
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/select2/dist/css/select2.css'),
);

$config['themes']['form']['js'] = array(
    array('pos' => 'head', 'src' => STATIC_PATH . 'asset/vendor/select2/dist/js/select2.min.js'),
);
