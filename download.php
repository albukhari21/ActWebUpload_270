<?php
if (isset($_GET['file']) && !empty($_GET['file'])) {
    $target_dir = "uploads/";
    
    // Keamanan: cegah pembacaan file di luar folder uploads (Directory Traversal)
    $file_name = basename($_GET['file']);
    $file_path = $target_dir . $file_name;

    if (file_exists($file_path) && is_file($file_path)) {
        // Headers untuk memicu dialog Download di browser
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $file_name . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file_path));
        
        // Baca file dan kirim ke output buffer
        readfile($file_path);
        exit;
    } else {
        $pesan = "File yang ingin diunduh tidak ditemukan.";
        header("Location: index.php?pesan=" . urlencode($pesan) . "&status=error");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>