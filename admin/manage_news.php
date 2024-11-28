<?php
require '../config/auth.php'; // Pastikan admin login
require '../config/database.php';

// Ambil semua berita dari MongoDB dan ubah menjadi array
$news = iterator_to_array($newsCollection->find([], ['sort' => ['created_at' => -1]]));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Berita</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-4">Kelola Berita</h1>
        <a href="add_news.php" class="btn btn-primary mb-4">Tambah Berita Baru</a>

        <?php if (empty($news)): ?>
            <div class="alert alert-warning">Tidak ada berita untuk ditampilkan.</div>
        <?php else: ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tanggal Dibuat</th>
                        <th>Tanggal Diupdate</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($news as $article): ?>
                        <tr>
                            <td><?= $article['title'] ?></td>
                            <td><?= $article['category'] ?></td>

                            <td><?php
                            $createdAt = $article['created_at']->toDateTime();
                            $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                            echo $createdAt->format('d-m-Y H:i');
                            ?></td>

                            <td><?php
                            $createdAt = $article['updated_at']->toDateTime();
                            $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                            echo $createdAt->format('d-m-Y H:i');
                            ?></td>

                            <td>
                                <a href="edit_news.php?id=<?= $article['_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="delete_news.php?id=<?= $article['_id'] ?>" class="btn btn-danger btn-sm"
                                    onclick="return confirm('Anda yakin ingin menghapus berita ini?')">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>

</html>