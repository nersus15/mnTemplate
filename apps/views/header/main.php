<!DOCTYPE html>
<html lang="id">
<?php 
    $manifest = json_decode(file_get_contents(STATIC_PATH . "docs/manifest.json"));
?>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta property="og:type" content="website" >
    <meta name="description" content="<?php echo isset($desc) ? $desc : $manifest->description?>">
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <?php if(!empty($manifest->keywords)):
        foreach($manifest->keywords as $key):?>
            <meta name="keywords" content="<?= $key ?>">
    <?php endforeach;endif?>
    <meta property="og:title" content="<?php echo isset($konten) ? $konten : APP_NAME ?>">
    <meta property="og:description" content="<?php echo isset($desc) ? $desc : $manifest->description?>">
    <meta property="og:url" content="<?php echo BASEURL ?>">
    <?php if(isset($thumb) || isset($manifest->image)): ?>
        <meta property="og:image" content="<?php echo isset($thumb) ? STATIC_PATH . $thumb  : STATIC_PATH . $manifest->image ?>">
    <?php endif?>
    <meta property="og:image:width" content="2250" />
    <meta property="og:image:height" content="2250" />>
    <?php if(isset($manifest->image)): ?>
    <link rel="icon" type="image/gif" href="<?php echo  STATIC_PATH . $manifest->image ?>">
    <?php endif?>
    <title><?php echo isset($title) ? $title : APP_NAME; ?></title>
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
        echo '<script src="'. TINY_URL .'" referrerpolicy="origin"></script>';
    

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

<body id="app-container" class="<?php echo DEF_THEME ? 'menu-default' : null ?>">
    <?php if (isset($loadingAnim) && $loadingAnim) : ?>
        <div class="c-overlay">
            <div class="c-overlay-text">Loading</div>
        </div>
    <?php endif ?>
    