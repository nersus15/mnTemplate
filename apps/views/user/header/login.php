<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Css Utama -->
    <link rel="stylesheet" href="<?= STATIC_PATH ?>vendor/bootstrap/css/bootstrap.css">

    <!-- extra css head -->
    <?php 
        if(!isset($extra_css) && !empty($extra_css)){
            foreach($extra_css as $css){
                if($css['position'] == "head")
                    echo '<link rel="stylesheet" href="' . $css['file'] . '">';
                    echo "<br>";
            }

        }   
    
    ?>

    <!-- Js Utama -->
    <script src="<?= STATIC_PATH ?>vendor/jquery/jquery.min.js"></script>
    <script src="<?= STATIC_PATH ?>js/popper.js"></script>
    <script src="<?= STATIC_PATH ?>vendor/bootstrap/js/bootstrap.js"></script>

    <!-- extra js head -->
    <?php 
        if(!isset($extra_js) && !empty($extra_js)){
            foreach($extra_js as $js){
                if($js['position'] == "head")
                    echo '<script src="' . $js['file'] . '"></script>';
                    echo "<br>";
            }
        }
    ?>
    
    <title><?= $page_title ?></title>
</head>