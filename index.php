<?php
include 'page/header.php';
    ?>





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




<?php
include 'page/footer.php';
?>