<?php
require '../config/database.php';
$id = new MongoDB\BSON\ObjectId($_GET['id']);
$article = $newsCollection->findOne(['_id' => $id]);
include 'page/header.php';
?>


<div class="container">
    <h1 class="my-4"><?= $article['title'] ?></h1>
    <p><strong>Penulis:</strong> <?= $article['author'] ?></p>
    <p><strong>Kategori:</strong> <?= $article['category'] ?></p>
    <p><strong>Diterbitkan:</strong>
        <?php
        // Ambil waktu yang disimpan di MongoDB (dalam UTC)
        $createdAt = $article['created_at']->toDateTime();

        // Set zona waktu ke WIB (Asia/Jakarta)
        $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));

        // Tampilkan waktu dalam format yang diinginkan (d-m-Y H:i)
        echo $createdAt->format('d-m-Y H:i');
        ?>
    </p>
    <hr>
    <!-- Konten berita dalam kotak -->
    <div class="content-box">
        <p><?= nl2br($article['content']) ?></p>
    </div>
    <!-- Tombol Edit dan Hapus -->
    <div class="mt-4">
        <a href="edit_news.php?id=<?= $article['_id'] ?>" class="btn btn-primary">Edit</a>
        <a href="delete_news.php?id=<?= $article['_id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">Hapus</a>
    </div>
</div>
<?php
include 'page/footer.php';
?>