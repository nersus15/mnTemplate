<?php
function upload_image($gambar, $tujuan, $conf = [])
{
    $config = array_merge([
        'maks' => 6_000_000,
        'name' => null,
        'sebelum' => null,
    ], $conf);

    // Validasi error upload
    if ($gambar['error'] !== UPLOAD_ERR_OK) {
        response(['message' => 'Upload gagal, kode error: ' . $gambar['error']], 500);
    }

    $nama_file   = $gambar['name'];
    $ukuran_file = $gambar['size'];
    $tmp         = $gambar['tmp_name'];
    $format_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    $format_sesuai = ['jpg', 'jpeg', 'png'];
    if (!in_array($format_file, $format_sesuai, true)) {
        response(['message' => 'Gagal, hanya boleh jpg/jpeg/png'], 500);
    }

    if ($ukuran_file <= 0 || $ukuran_file > $config['maks']) {
        response(['message' => 'Gagal, ukuran file tidak valid'], 500);
    }

    // Validasi MIME type
    $mime = mime_content_type($tmp);
    if (!in_array($mime, ['image/jpeg', 'image/png'], true)) {
        response(['message' => 'Gagal, file bukan gambar valid'], 500);
    }

    // === Tentukan nama file ===
    if (!empty($config['name'])) {
        $nama_image = $config['name'] . '.' . $format_file;
    } else {
        // Generate random string aman untuk PHP 7 & 8
        if (function_exists('random_bytes')) {
            $random = bin2hex(random_bytes(8)); // 16 karakter hex
        } else {
            $random = uniqid('', true); // fallback PHP < 7
        }
        $nama_image = $random . '.' . $format_file;
    }

    // === Tentukan path tujuan (cross-platform) ===
    $dest_dir  = rtrim(realpath($tujuan), DIRECTORY_SEPARATOR);
    if ($dest_dir === false) {
        response(['message' => 'Path tujuan tidak valid'], 500);
    }
    $path_dest = $dest_dir . DIRECTORY_SEPARATOR . $nama_image;

    // Pindahkan file upload
    if (!move_uploaded_file($tmp, $path_dest)) {
        response(['message' => 'Gagal memindahkan file upload'], 500);
    }

    // Hapus file lama jika ada
    if (!empty($config['sebelum'])) {
        $old = $dest_dir . DIRECTORY_SEPARATOR . $config['sebelum'];
        if (file_exists($old)) {
            @unlink($old);
        }
    }

    return $nama_image;
}
