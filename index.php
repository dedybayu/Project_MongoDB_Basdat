<?php
require 'config/database.php';
$news = $newsCollection->find([], ['sort' => ['created_at' => -1]]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Terkini</title>
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
    <!-- Footer -->
    <div class="footer">
        &copy; 2024 Berita.com. All Rights Reserved
    </div>
</body>

</html>