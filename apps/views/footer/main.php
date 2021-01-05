<?php
if (isset($resource) && !empty($resource)) {
    foreach ($resource as $k => $v) {
        echo add_resource_group($v, null, 'body:end');
    }
}
if (isset($extra_js) && !empty($extra_js)) {
    foreach ($extra_js as $js) {
        if ($js['pos'] == 'body:end' && $js['type'] == 'file')
            echo '<script src="' . $js['src'] . '"></script>';
        elseif ($js['pos'] == 'body:end' && $js['type'] == 'inline') {
            echo '<script>' . $js['script'] . '</script>';
        }
    }
}

if (isset($extra_css) && !empty($extra_css)) {
    foreach ($extra_css as $css) {
        if ($css['pos'] == 'body:end' && $css['type'] == 'file')
            echo '<script src="' . $css['src'] . '"></script>';
        elseif ($css['pos'] == 'body:end' && $css['type'] == 'inline') {
            echo '<style>' . $css['style'] . '</style>';
        }
    }
}
?>
</body>

</html>