<?php
class uploader
{
    function uploadImage($tujuan, $default, $asal, $fotoSebelumnya = null)
    {
        $nama_file = $_FILES['image']['name'];
        $ukuran_file = $_FILES['image']['size'];
        $error = $_FILES['image']['error'];
        $tmp = $_FILES['image']['tmp_name'];
        $format_sesuai = ['jpg', 'jpeg', 'png'];
        $format_file = explode('.', $nama_file);
        $format_file = strtolower(end($format_file));
        if (!in_array($format_file, $format_sesuai)) {
            flasher::setFlash('Gagal, Pilih file yang Valid jpg/jpeg/png', 'danger');
            header('location: ' . $asal);
        } elseif ($ukuran_file > 2500000) {
            flasher::setFlash('Gagal, size file yang dipilih terlalu besar', 'danger');
            header('location: ' . $asal);
        } else {
            $nama_image = uniqId();
            $nama_image .= ".";
            $nama_image .= $format_file;
            move_uploaded_file($tmp, $tujuan . $nama_image);
            if ($fotoSebelumnya) {
                unlink($tujuan . $fotoSebelumnya);
            }
            return $nama_image;
        }
    }
}
