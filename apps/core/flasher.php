<?php
class flasher
{
    public static function setFlash($pesan, $type)
    {
        $_SESSION['flash'] = [
            'pesan' => $pesan,
            'type' => $type
        ];
    }
    public static function flash()
    {
        if (isset($_SESSION['flash'])) {
            echo '<div class="alert alert-' . $_SESSION['flash']['type'] . ' alert-dismissible fade show" role="alert">
           <strong>' . $_SESSION['flash']['pesan'] . '          
          </div>';
            unset($_SESSION['flash']);
        }
    }
}
