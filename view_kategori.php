<?php
require 'config/database.php';  

$category = isset($_GET['category']) ? $_GET['category'] : null;

$filter = [];
if ($category) {
    $filter['category'] = $category;  
}

$news = $newsCollection->find($filter, ['sort' => ['created_at' => -1]]);
$newsArray = iterator_to_array($news); 

include 'page/header.php';
?>

<div class="container">
    <h1 class="my-4">Berita Terkini<?php echo $category ? " - Kategori: $category" : ''; ?></h1> <!-- Menampilkan kategori di judul -->

    <form action="search.php" method="get" class="mb-4">
        <input type="text" name="q" class="form-control" placeholder="Cari berita...">
    </form>
    
    <div class="list-group">
        <?php
        if (count($newsArray) == 0) {
            echo "<p>Tidak ada berita untuk kategori ini.</p>";
        } else {
            foreach ($newsArray as $article): ?>
                <a href="news_detail.php?id=<?= $article['_id'] ?>" class="list-group-item">
                    <h5><?= $article['title'] ?></h5>
                    <p><?= $article['summary'] ?></p>
                    <small>Create at: <?php
                    $createdAt = $article['created_at']->toDateTime();
                    $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                    echo $createdAt->format('d-m-Y H:i');
                    ?></small>
                    <br>
                    <small>Update at: <?php
                    $updatedAt = $article['updated_at']->toDateTime();
                    $updatedAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                    echo $updatedAt->format('d-m-Y H:i');
                    ?></small>
                </a>

            <?php endforeach;
        }
        ?>
    </div>
</div>

<?php
include 'page/footer.php';
?>
