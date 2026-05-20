<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Foto Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 min-h-screen p-6 font-sans text-gray-800">

    <div class="max-w-5xl mx-auto">
        <header class="text-center mb-10">
            <h1 class="text-3xl font-bold text-indigo-600 mb-2">Manajemen Galeri Foto</h1>
            <p class="text-gray-500">Unggah, unduh, dan kelola foto dengan aman.</p>
        </header>

        <?php if (isset($_GET['pesan'])): ?>
            <div class="p-4 mb-6 rounded-lg text-white text-center font-medium <?php echo ($_GET['status'] == 'success') ? 'bg-green-500' : 'bg-red-500'; ?>">
                <?php echo htmlspecialchars($_GET['pesan']); ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 mb-10">
            <form action="upload.php" method="post" enctype="multipart/form-data" class="flex flex-col md:flex-row items-center gap-4">
                <div class="flex-1 w-full">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Foto (JPG, PNG, GIF, WEBP)</label>
                    <input type="file" name="fileToUpload" required accept="image/*"
                        class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer">
                </div>
                <button type="submit" name="submit" class="w-full md:w-auto mt-6 md:mt-0 px-6 py-2 bg-indigo-600 text-white rounded-md font-medium hover:bg-indigo-700 transition-colors">
                    Unggah Foto
                </button>
            </form>
        </div>

        <h2 class="text-2xl font-semibold mb-4 border-b pb-2">Koleksi Foto</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php
            $target_dir = "uploads/";
            // Buat folder jika belum ada
            if (!file_exists($target_dir)) { mkdir($target_dir, 0777, true); }
            
            $files = scandir($target_dir);
            $has_photos = false;

            foreach($files as $file) {
                if($file !== '.' && $file !== '..') {
                    $has_photos = true;
                    $filepath = $target_dir . $file;
                    ?>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-shadow group">
                        <div class="h-48 overflow-hidden bg-gray-100 flex items-center justify-center">
                            <img src="<?php echo $filepath; ?>" alt="<?php echo $file; ?>" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-4">
                            <p class="text-sm text-gray-600 truncate mb-4" title="<?php echo $file; ?>"><?php echo $file; ?></p>
                            <div class="flex justify-between gap-2">
                                <a href="download.php?file=<?php echo urlencode($file); ?>" class="flex-1 text-center py-1.5 px-3 bg-blue-50 text-blue-600 text-sm font-medium rounded hover:bg-blue-100 transition-colors">Unduh</a>
                                
                                <form action="delete.php" method="POST" class="flex-1" onsubmit="return confirm('Yakin ingin menghapus foto ini?');">
                                    <input type="hidden" name="file_name" value="<?php echo htmlspecialchars($file); ?>">
                                    <button type="submit" name="delete_file" class="w-full py-1.5 px-3 bg-red-50 text-red-600 text-sm font-medium rounded hover:bg-red-100 transition-colors">Hapus</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            if (!$has_photos) {
                echo "<div class='col-span-full text-center py-10 text-gray-400'>Belum ada foto yang diunggah.</div>";
            }
            ?>
        </div>
    </div>
</body>
</html>