<?php
$dir = __DIR__ . '/uploads/';
$files = array_diff(scandir($dir), ['.','..']);

// Proses delete
if (isset($_GET['delete'])) {
    $fileToDelete = basename($_GET['delete']);
    $fullPath = $dir . $fileToDelete;
    if (in_array($fileToDelete, $files) && file_exists($fullPath)) {
        unlink($fullPath);
        header("Location: gallery.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Galeri File Pengguna</title>
    <style>
        .thumb, .pdf-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            margin: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
            transition: transform .2s;
        }
        .thumb:hover, .pdf-preview:hover {
            transform: scale(1.05);
            cursor: pointer;
        }
        .gallery { display: flex; flex-wrap: wrap; }
        .item { position: relative; margin: 10px; text-align: center; }
        .btn {
            display: inline-block;
            margin: 5px;
            padding: 4px 8px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 0.9rem;
        }
        .download { background: #4CAF50; color: white; }
        .delete   { background: #F44336; color: white; }
        a.upload-link {
            display: inline-block;
            margin-bottom: 20px;
            text-decoration: none;
            color: #007BFF;
        }
    </style>
    <script>
    function confirmDelete(filename) {
        if (confirm("Yakin ingin menghapus '" + filename + "'?")) {
            window.location.href = "gallery.php?delete=" + encodeURIComponent(filename);
        }
    }
    </script>
</head>
<body>

<h2>Galeri File Pengguna</h2>
<a href="index.html" class="upload-link">&larr; Kembali ke Upload</a>
<div class="gallery">
    <?php if (empty($files)): ?>
        <p>Belum ada file diunggah.</p>
    <?php else: ?>
        <?php foreach ($files as $file): 
            $url = 'uploads/' . urlencode($file);
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
            $isPDF   = $ext === 'pdf';
        ?>
            <div class="item">
                <?php if ($isImage): ?>
                    <!-- Thumbnail gambar biasa -->
                    <a href="<?= $url ?>" target="_blank">
                        <img src="<?= $url ?>" class="thumb" alt="<?= htmlspecialchars($file) ?>">
                    </a>

                <?php elseif ($isPDF): ?>
                    <!-- Embed PDF langsung di grid -->
                    <a href="<?= $url ?>" target="_blank">
                        <object data="<?= $url ?>" type="application/pdf" class="pdf-preview">
                            <!-- Fallback kalau object gagal -->
                            <img src="https://cdn-icons-png.flaticon.com/512/337/337946.png"
                                 class="thumb" alt="PDF <?= htmlspecialchars($file) ?>">
                        </object>
                    </a>

                <?php else: ?>
                    <!-- Placeholder untuk tipe file lain -->
                    <div class="thumb" style="display:flex;align-items:center;justify-content:center;">
                        <span><?= htmlspecialchars(strtoupper($ext)) ?></span>
                    </div>
                <?php endif; ?>

                <div>
                    <a href="<?= $url ?>" download="<?= htmlspecialchars($file) ?>" class="btn download">Unduh</a>
                    <button onclick="confirmDelete('<?= htmlspecialchars($file) ?>')" class="btn delete">Hapus</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>
