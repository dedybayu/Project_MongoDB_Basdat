<?php
require '../config/auth.php'; // Pastikan admin login
require '../config/database.php';

// Ambil data berita berdasarkan ID
$id = new MongoDB\BSON\ObjectId($_GET['id']);
$article = $newsCollection->findOne(['_id' => $id]);

// Proses form jika data disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil waktu sistem server yang disesuaikan dengan WIB (UTC+7)
    $wibNow = new DateTime("now", new DateTimeZone('Asia/Jakarta')); // Zona waktu WIB

    // Mengonversi waktu ke MongoDB format UTCDateTime
    $mongoDate = new MongoDB\BSON\UTCDateTime($wibNow->getTimestamp() * 1000); // Mengalikan dengan 1000 untuk milidetik

    // Update artikel dengan waktu sistem untuk updated_at
    $newsCollection->updateOne(
        ['_id' => $id],
        ['$set' => [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'summary' => $_POST['summary'],
            'category' => $_POST['category'],
            'author' => $_POST['author'],
            'updated_at' => $mongoDate // Gunakan waktu sistem yang sudah disesuaikan dengan WIB
        ]]
    );

    // Redirect setelah update
    header('Location: manage_news.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Berita</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Edit Berita</h1>

        <form action="" method="post">
            <div class="form-group">
                <label for="title">Judul</label>
                <input type="text" name="title" id="title" class="form-control" value="<?= $article['title'] ?>" required>
            </div>
            <div class="form-group">
                <label for="content">Konten</label>
                <textarea name="content" id="content" class="form-control" rows="5" required><?= $article['content'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="summary">Ringkasan</label>
                <textarea name="summary" id="summary" class="form-control" rows="2" required><?= $article['summary'] ?></textarea>
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
                </select>
            </div>
            <div class="form-group">
                <label for="author">Penulis</label>
                <input type="text" name="author" id="author" class="form-control" value="<?= $article['author'] ?>" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
    </div>
</body>

</html>