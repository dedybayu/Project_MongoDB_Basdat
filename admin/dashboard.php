<?php
require '../config/auth.php'; // Pastikan admin login
include 'page/header.php';
?>

<div class="container">
    <h1 class="my-4">Berita Terkini</h1>
    <form action="search.php" method="get" class="mb-4">
        <input type="text" name="q" class="form-control" placeholder="Cari berita...">
    </form>
    <div class="list-group">
        <?php foreach ($news as $article): ?>
            <a href="view_detail.php?id=<?= $article['_id'] ?>" class="list-group-item">
                <h5><?= $article['title'] ?></h5>
                <p><?= $article['summary'] ?></p>
                <small>Create at: <?php
                $createdAt = $article['created_at']->toDateTime();
                $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                echo $createdAt->format('d-m-Y H:i');
                ?></small>
                <br>
                <small>Update at: <?php
                $createdAt = $article['updated_at']->toDateTime();
                $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                echo $createdAt->format('d-m-Y H:i');
                ?></small>
            </a>
        <?php endforeach; ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const categoryLinks = document.querySelectorAll('.category-link');

        categoryLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault(); 
                const parentLi = link.parentElement;
                parentLi.classList.toggle('open');
            });
        });
    });
</script>


<?php
include 'page/footer.php';
?>