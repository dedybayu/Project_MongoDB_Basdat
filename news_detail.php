<?php
require 'config/database.php';
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
        $createdAt = $article['created_at']->toDateTime();
        $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
        echo $createdAt->format('d-m-Y H:i');
        ?>
    </p>
    <hr>
    <div class="content-box">
        <p><?= nl2br($article['content']) ?></p>
    </div>
</div>
<?php
include 'page/footer.php';
?>