<?php
require '../config/auth.php'; // Pastikan admin login
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil waktu sistem berdasarkan zona waktu Indonesia (WIB)
    $wibNow = new DateTime("now", new DateTimeZone('Asia/Jakarta'));

    // Konversi waktu ke format MongoDB UTCDateTime
    $mongoDate = new MongoDB\BSON\UTCDateTime($wibNow->getTimestamp() * 1000); // Mengalikan dengan 1000 untuk milidetik

    // Validasi file gambar
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $imageFile = $_FILES['image']['tmp_name'];
        $imageSize = $_FILES['image']['size'];
        $imageType = $_FILES['image']['type'];

        // Validasi tipe file gambar
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif']; // Bisa tambahkan format lain jika diperlukan
        if (in_array($imageType, $allowedTypes) && $imageSize <= 5 * 1024 * 1024) { // Maksimum ukuran 5MB
            // Baca file gambar sebagai binary
            $imageData = file_get_contents($imageFile);
        } else {
            // Jika file tidak valid
            echo "Format file atau ukuran gambar tidak valid.";
            exit;
        }
    } else {
        // Jika gambar tidak ada atau ada error
        $imageData = null; // Set null jika tidak ada gambar yang diunggah
    }

    // Insert data berita ke dalam collection
    $newsCollection->insertOne([
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'summary' => $_POST['summary'],
        'category' => $_POST['category'],
        'author' => $_POST['author'],
        'created_at' => $mongoDate, // Menggunakan waktu lokal
        'updated_at' => $mongoDate, // Menggunakan waktu lokal
        'image' => $imageData ? new MongoDB\BSON\Binary($imageData, MongoDB\BSON\Binary::TYPE_GENERIC) : null // Simpan binary data atau null
    ]);

    // Insert data notifikasi ke dalam collection
    $notificationsCollection->insertOne([
        'message' => "Berita baru berjudul '{$_POST['title']}' telah ditambahkan.",
        'status' => 'unread',
        'created_at' => $mongoDate
    ]);

    // Redirect ke halaman manajemen berita setelah menyimpan
    header('Location: manage_news.php');
    exit;
}
?>

<?php
require '../config/auth.php'; // Pastikan admin login
include 'page/header-admin.php';
?>

<div class="container">
    <h1 class="my-4">Tambah Berita</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="title">Judul</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="content">Konten</label>
            <textarea name="content" id="content" class="form-control" rows="5" required></textarea>
        </div>
        <div class="form-group">
            <label for="summary">Ringkasan</label>
            <textarea name="summary" id="summary" class="form-control" rows="2" required></textarea>
        </div>
        <div class="form-group">
            <label for="category">Kategori</label>
            <select name="category" id="category" class="form-control" required>
                <option value="" disabled selected>-- Pilih Kategori --</option>
                <option value="Teknologi">Teknologi</option>
                <option value="Politik">Politik</option>
                <option value="Pendidikan">Pendidikan</option>
                <option value="Kesehatan">Kesehatan</option>
                <option value="Hiburan">Hiburan</option>
                <option value="Olahraga">Olahraga</option>
                <option value="Kriminal">Kriminal</option>
                <option value="Lingkungan">Lingkungan</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

        <div class="form-group">
            <label for="author">Penulis</label>
            <input type="text" name="author" id="author" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="image">Gambar</label>
            <input type="file" name="image" id="image" class="form-control" accept="image/*" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>

<?php
include 'page/footer-admin.php';
?>
