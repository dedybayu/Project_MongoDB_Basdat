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
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" class="navbar-brand">Berita.com</a>
            <ul class="navbar-links">
                <li><a href="#">Home</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-links">
            <li><a href="#">Dashboard</a></li>
            <li><a href="#">News</a></li>
            <li><a href="#">Settings</a></li>
        </ul>
    </div>

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
    </div>
    <!-- Footer -->
    <div class="footer">
        &copy; 2024 Berita.com. All Rights Reserved
    </div>
</body>

</html>