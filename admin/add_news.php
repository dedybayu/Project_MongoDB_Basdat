<?php
require '../config/auth.php'; // Pastikan admin login
require '../config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil waktu sistem berdasarkan zona waktu Indonesia (WIB)
    $wibNow = new DateTime("now", new DateTimeZone('Asia/Jakarta'));

    // Konversi waktu ke format MongoDB UTCDateTime
    $mongoDate = new MongoDB\BSON\UTCDateTime($wibNow->getTimestamp() * 1000); // Mengalikan dengan 1000 untuk milidetik

    // Insert data berita ke dalam collection
    $newsCollection->insertOne([
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'summary' => $_POST['summary'],
        'category' => $_POST['category'],
        'author' => $_POST['author'],
        'created_at' => $mongoDate, // Menggunakan waktu lokal
        'updated_at' => $mongoDate  // Menggunakan waktu lokal
    ]);

    // Redirect ke halaman manajemen berita setelah menyimpan
    header('Location: manage_news.php');
    exit;
}
?>
<?php
require '../config/auth.php'; // Pastikan admin login
include 'page/header.php';

?>
    <div class="container">
        <h1 class="my-4">Tambah Berita</h1>
        <form action="" method="post">
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
                    <option value="Teknologi" <?php echo isset($article['category']) && $article['category'] == 'Teknologi' ? 'selected' : ''; ?>>Teknologi</option>
                    <option value="Politik" <?php echo isset($article['category']) && $article['category'] == 'Politik' ? 'selected' : ''; ?>>Politik</option>
                    <option value="Pendidikan" <?php echo isset($article['category']) && $article['category'] == 'Pendidikan' ? 'selected' : ''; ?>>Pendidikan</option>
                    <option value="Kesehatan" <?php echo isset($article['category']) && $article['category'] == 'Kesehatan' ? 'selected' : ''; ?>>Kesehatan</option>
                    <option value="Hiburan" <?php echo isset($article['category']) && $article['category'] == 'Hiburan' ? 'selected' : ''; ?>>Hiburan</option>
                    <option value="Olahraga" <?php echo isset($article['category']) && $article['category'] == 'Olahraga' ? 'selected' : ''; ?>>Olahraga</option>
                    <option value="Kriminal" <?php echo isset($article['category']) && $article['category'] == 'Kriminal' ? 'selected' : ''; ?>>Kriminal</option>
                    <option value="Lingkungan" <?php echo isset($article['category']) && $article['category'] == 'Lingkungan' ? 'selected' : ''; ?>>Lingkungan</option>
                     <option value="Lainnya" <?php echo isset($article['category']) && $article['category'] == 'Lainnya' ? 'selected' : ''; ?>>Lainnya</option>
                </select>
            </div>

            <div class="form-group">
                <label for="author">Penulis</label>
                <input type="text" name="author" id="author" class="form-control" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </form>
    </div>
<?php
include 'page/footer.php';
?>