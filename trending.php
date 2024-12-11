<?php
include 'page/header.php';

// Fetch news articles sorted by the number of views in descending order
$news = $newsCollection->find([], [
    'sort' => ['jumlah_views' => -1]  // Sort by 'jumlah_views' in descending order
]);
?>
<div class="container">
    <h1 class="my-4">Berita Trending</h1>
    <form action="search.php" method="get" class="mb-4">
        <input type="text" name="q" class="form-control" placeholder="Cari berita...">
    </form>
    <div class="list-group">
        <?php foreach ($news as $article): ?>
            <a href="news_detail.php?id=<?= $article['_id'] ?>" class="list-group-item">
                <h5><?= htmlspecialchars($article['title']) ?></h5>
                <p><?= htmlspecialchars($article['summary']) ?></p>
                <small>Created at: <?php
                // Ambil waktu yang disimpan di MongoDB (dalam UTC)
                $createdAt = $article['created_at']->toDateTime();

                // Set zona waktu ke WIB (Asia/Jakarta)
                $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));

                // Tampilkan waktu dalam format yang diinginkan (d-m-Y H:i)
                echo $createdAt->format('d-m-Y H:i');
                ?></small>
                <br>
                <small>Updated at: <?php
                // Ambil waktu yang disimpan di MongoDB (dalam UTC)
                $updatedAt = $article['updated_at']->toDateTime();

                // Set zona waktu ke WIB (Asia/Jakarta)
                $updatedAt->setTimezone(new DateTimeZone('Asia/Jakarta'));

                // Tampilkan waktu dalam format yang diinginkan (d-m-Y H:i)
                echo $updatedAt->format('d-m-Y H:i');
                ?></small>
                <br>
                <small>Jumlah Views: <?= isset($article['jumlah_views']) ? $article['jumlah_views'] : 0 ?></small>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Pilih semua tautan kategori yang memiliki kelas 'category-link'
        const categoryLinks = document.querySelectorAll('.category-link');

        categoryLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault(); // Mencegah default aksi tautan
                const parentLi = link.parentElement; // Ambil elemen <li> induk
                parentLi.classList.toggle('open'); // Menambahkan / menghapus kelas 'open'
            });
        });
    });
</script>

<?php
include 'page/footer.php';
?>