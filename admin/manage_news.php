<?php
require '../config/auth.php'; 
require '../config/database.php';

$news = iterator_to_array($newsCollection->find([], ['sort' => ['created_at' => -1]]));

include 'page/header-admin.php';
?>

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
<?php
include 'page/footer-admin.php';
?>