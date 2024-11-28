<?php
require 'config/database.php';

$keyword = $_GET['q'];
$results = $newsCollection->find(
    ['title' => ['$regex' => $keyword, '$options' => 'i']],
    ['projection' => ['title' => 1, 'summary' => 1, 'created_at' => 1]]
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="my-4">Hasil Pencarian</h1>
    <div class="list-group">
        <?php foreach ($results as $article): ?>
            <a href="news_detail.php?id=<?= $article['_id'] ?>" class="list-group-item">
                <h5><?= $article['title'] ?></h5>
                <p><?= $article['summary'] ?></p>
                <small><?= $article['created_at']->toDateTime()->format('d-m-Y H:i') ?></small>
            </a>
        <?php endforeach; ?>
    </div>
</div>
</body>
</html>
