<?php
require 'config/database.php';
$id = new MongoDB\BSON\ObjectId($_GET['id']);
$article = $newsCollection->findOne(['_id' => $id]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $article['title'] ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body>
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
        <p><?= nl2br($article['content']) ?></p>
    </div>
</body>

</html>