<?php
$target_dir = "uploads/";
if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }

if (isset($_POST["submit"])) {
    $original_filename = basename($_FILES["fileToUpload"]["name"]);
    $safe_filename = preg_replace("/[^a-zA-Z0-9\._-]/", "", $original_filename); // Cegah nama file aneh
    $target_file = $target_dir . $safe_filename;
    
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $pesan = "";
    $status = "error";

    // A. Pastikan benar-benar gambar
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if ($check === false) {
        $pesan = "Gagal: File yang diunggah BUKAN gambar.";
        $uploadOk = 0;
    }

    // B. Batasi ukuran (Maks 2MB)
    elseif ($_FILES["fileToUpload"]["size"] > 2000000) {
        $pesan = "Gagal: Ukuran file maksimal 2MB.";
        $uploadOk = 0;
    }

    // C. Cek Ekstensi
    $allowed_types = array("jpg", "jpeg", "png", "gif", "webp");
    if (!in_array($fileType, $allowed_types) && $uploadOk == 1) {
        $pesan = "Gagal: Hanya format JPG, JPEG, PNG, GIF, & WEBP yang diizinkan.";
        $uploadOk = 0;
    }

    // D. Ganti nama jika file sudah ada (agar tidak tertimpa)
    if (file_exists($target_file) && $uploadOk == 1) {
        $filename_without_ext = pathinfo($safe_filename, PATHINFO_FILENAME);
        $target_file = $target_dir . $filename_without_ext . "_" . time() . "." . $fileType;
    }

    // E. Eksekusi Upload
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            $pesan = "Berhasil mengunggah foto!";
            $status = "success";
        } else {
            $pesan = "Gagal: Kesalahan sistem saat mengunggah foto.";
        }
    }
    
    // Redirect kembali ke index
    header("Location: index.php?pesan=" . urlencode($pesan) . "&status=" . $status);
    exit();
} else {
    header("Location: index.php");
    exit();
}
?>