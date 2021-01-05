<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website" >
    <meta name="description" content="<?php echo isset($desc) ? $desc : 'Website Himpunan Pelajar Mahasiswa Sukarara (HIPELMAS)'?>">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <meta name="keywords" content="hipelmas">
    <meta name="keywords" content="himpunan mahasiswa sukarara">
    <meta name="keywords" content="sukarara">
    <meta property="og:title" content="<?php echo isset($konten) ? $konten : 'HIPELMAS' ?>">
    <meta property="og:description" content="<?php echo isset($desc) ? $desc : 'Website Himpunan Pelajar Mahasiswa Sukarara (HIPELMAS)'?>">
    <meta property="og:url" content="<?php echo BASEURL ?>">
    <meta property="og:image" content="<?php echo isset($thumb) ? STATIC_PATH . $thumb  : STATIC_PATH . 'img/logo/hipelmas.png' ?>">
    <meta property="og:image:width" content="2250" />
    <meta property="og:image:height" content="2250" />
    <link rel="icon" type="image/gif" href="<?php echo STATIC_PATH . 'img/logo/hipelmas.png' ?>">
    
    <title><?php echo isset($title) ? $title : 'Hipelmas'; ?></title>
    <?php
    // var_dump($resource);die;
    if (isset($resource) && !empty($resource)) {
        foreach ($resource as $k => $v) {
            echo add_resource_group($v);
        }
    }
    if (isset($extra_js) && !empty($extra_js)) {
        foreach ($extra_js as $js) {
            if ($js['pos'] == 'head' && $js['type'] == 'file')
                echo '<script src="' . $js['src'] . '"></script>';
            elseif ($js['pos'] == 'head' && $js['type'] == 'inline') {
                echo '<script>' . $js['script'] . '</script>';
            }
        }
    }
    if(isset($includeTiny) && $includeTiny)
        echo '<script src="https://cdn.tiny.cloud/1/g3ehl5o7qpuuksdy89uuxe73fv2lmbk7d7374gxeeuts8z8w/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>';
    

    if (isset($extra_css) && !empty($extra_css)) {
        foreach ($extra_css as $css) {
            if ($css['pos'] == 'head' && $css['type'] == 'file')
                echo '<link rel="stylesheet" href="' . $css['src'] . '"></link>';
            elseif ($css['pos'] == 'head' && $css['type'] == 'inline') {
                echo '<style>' . $css['style'] . '</style>';
            }
        }
    }
    ?>
    <script>
        var path = location.origin + '/';
    </script>
</head>

<body id="app-container" class="menu-default">
    <?php if (isset($loadingAnim) && $loadingAnim) : ?>
        <div class="c-overlay">
            <div class="c-overlay-text">Loading</div>
        </div>
    <?php endif ?>