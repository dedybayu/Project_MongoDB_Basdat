<?php
include 'page/header.php';
    ?>




<div class="container">
    <h1 class="my-4">Berita Terkini</h1>
    <form action="search.php" method="get" class="mb-4">
        <input type="text" name="q" class="form-control" placeholder="Cari berita...">
    </form>
    <div class="list-group">
        <?php foreach ($news as $article): ?>
            <a href="news_detail.php?id=<?= $article['_id'] ?>" class="list-group-item">
                <h5><?= $article['title'] ?></h5>
                <p><?= $article['summary'] ?></p>
                <small>Create at: <?php
                // Ambil waktu yang disimpan di MongoDB (dalam UTC)
                $createdAt = $article['created_at']->toDateTime();

                // Set zona waktu ke WIB (Asia/Jakarta)
                $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));

                // Tampilkan waktu dalam format yang diinginkan (d-m-Y H:i)
                echo $createdAt->format('d-m-Y H:i');
                ?></small>
                <br>
                <small>Update at: <?php
                // Ambil waktu yang disimpan di MongoDB (dalam UTC)
                $createdAt = $article['updated_at']->toDateTime();

                // Set zona waktu ke WIB (Asia/Jakarta)
                $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));

                // Tampilkan waktu dalam format yang diinginkan (d-m-Y H:i)
                echo $createdAt->format('d-m-Y H:i');
                ?></small>
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