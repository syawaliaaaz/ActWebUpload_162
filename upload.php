<?php
// upload.php

// Cek request dan file input
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['fileToUpload'])) {
    $file     = $_FILES['fileToUpload'];
    $error    = $file['error'];
    $tmpName  = $file['tmp_name'];
    $original = $file['name'];
    $ext      = strtolower(pathinfo($original, PATHINFO_EXTENSION));
    $allowed  = ['jpg','jpeg','png','gif','webp','pdf'];

    // Cek error upload
    if ($error !== UPLOAD_ERR_OK) {
        die("Terjadi kesalahan saat upload. Kode error: $error");
    }

    // Cek ekstensi
    if (!in_array($ext, $allowed)) {
        die("Format file tidak didukung: .$ext");
    }

    // Siapkan folder uploads
    $uploadDir = __DIR__ . '/uploads/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}


    // Buat nama unik: timestamp + random + ext
    $newName = time() . '_' . bin2hex(random_bytes(4)) . '.' . $ext;
    $dest    = $uploadDir . $newName;

    // Pindahkan file
    if (move_uploaded_file($tmpName, $dest)) {
        // Sukses: redirect ke galeri
        header("Location: gallery.php");
        exit;
    } else {
        die("Gagal memindahkan file ke folder uploads.");
    }
} else {
    // Kalau direct akses: kembali ke form
    header("Location: index.html");
    exit;
}
