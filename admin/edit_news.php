<?php
require '../config/auth.php'; // Pastikan admin login
require '../config/database.php';

// Ambil data berita berdasarkan ID
$id = new MongoDB\BSON\ObjectId($_GET['id']);
$article = $newsCollection->findOne(['_id' => $id]);

// Proses form jika data disubmit
// Proses form jika data disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil waktu sistem server yang disesuaikan dengan WIB (UTC+7)
    $wibNow = new DateTime("now", new DateTimeZone('Asia/Jakarta')); // Zona waktu WIB

    // Mengonversi waktu ke MongoDB format UTCDateTime
    $mongoDate = new MongoDB\BSON\UTCDateTime($wibNow->getTimestamp() * 1000); // Mengalikan dengan 1000 untuk milidetik

    // Handle image upload if provided
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        // Validasi dan upload gambar
        $imageData = file_get_contents($_FILES['image']['tmp_name']);
        $image = new MongoDB\BSON\Binary($imageData, MongoDB\BSON\Binary::TYPE_GENERIC);
    } else {
        // If no image uploaded, keep the existing image
        $image = isset($article['image']) ? $article['image'] : null;
    }

    // Update artikel dengan waktu sistem dan gambar
    $newsCollection->updateOne(
        ['_id' => $id],
        ['$set' => [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'summary' => $_POST['summary'],
            'category' => $_POST['category'],
            'author' => $_POST['author'],
            'updated_at' => $mongoDate, // Gunakan waktu sistem yang sudah disesuaikan dengan WIB
            'image' => $image // Simpan gambar baru atau gambar yang sudah ada
        ]]
    );

    // Redirect setelah update
    header('Location: manage_news.php');
    exit;
}


include 'page/header.php';
?>

    <div class="container">
        <h1 class="my-4">Edit Berita</h1>

        <form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="title">Judul</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= htmlspecialchars($article['title']) ?>" required>
    </div>
    <div class="form-group">
        <label for="content">Konten</label>
        <textarea name="content" id="content" class="form-control" rows="5" required><?= htmlspecialchars($article['content']) ?></textarea>
    </div>
    <div class="form-group">
        <label for="summary">Ringkasan</label>
        <textarea name="summary" id="summary" class="form-control" rows="2" required><?= htmlspecialchars($article['summary']) ?></textarea>
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
        <input type="text" name="author" id="author" class="form-control" value="<?= htmlspecialchars($article['author']) ?>" required>
    </div>
    <div class="form-group">
        <label for="image">Gambar</label>
        <input type="file" name="image" id="image" class="form-control" accept="image/*">
        <?php if (isset($article['image'])): ?>
            <p><strong>Gambar saat ini:</strong></p>
            <img src="data:image/jpeg;base64,<?= base64_encode($article['image']->getData()) ?>" alt="Gambar Berita" class="img-fluid" width="200px">
        <?php endif; ?>
    </div>
    <br>
    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
</form>

    </div>
<?php
include 'page/footer.php';
?>