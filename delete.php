<?php
if (isset($_POST['delete_file']) && !empty($_POST['file_name'])) {
    $target_dir = "uploads/";
    
    // Gunakan basename untuk mencegah Directory Traversal Attack
    $file_to_delete = basename($_POST['file_name']); 
    $file_path = $target_dir . $file_to_delete;
    
    if (file_exists($file_path) && is_file($file_path)) {
        unlink($file_path);
        $pesan = "Foto berhasil dihapus.";
        $status = "success";
    } else {
        $pesan = "Gagal: File tidak ditemukan.";
        $status = "error";
    }

    header("Location: index.php?pesan=" . urlencode($pesan) . "&status=" . $status);
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>