<?php
require 'config/database.php';

$keyword = $_GET['q'];
if ($keyword === '') {
    header("Location: index.php");
}
$cursor = $newsCollection->find(
    ['title' => ['$regex' => $keyword, '$options' => 'i']],
    ['projection' => ['title' => 1, 'summary' => 1, 'created_at' => 1]]
);

// Ubah cursor menjadi array
$results = iterator_to_array($cursor);

include 'page/header.php';
?>

<div class="container">
    <h1 class="my-4">Berita Terkini</h1>
    <form action="search.php" method="get" class="mb-4">
        <input type="text" name="q" class="form-control" placeholder="Cari berita...">
    </form>
    <h3 class="my-4">Hasil Pencarian "<?= $_GET['q'] ?>"</h3>
    <div class="list-group">

        <?php
        if (count($results) === 0) {
            echo "<p>Tidak ada Berita</p>";
        } else {
            foreach ($results as $article): ?>
                <a href="news_detail.php?id=<?= $article['_id'] ?>" class="list-group-item">
                    <h5><?= $article['title'] ?></h5>
                    <p><?= $article['summary'] ?></p>
                    <small><?= $article['created_at']->toDateTime()->format('d-m-Y H:i') ?></small>
                </a>
            <?php endforeach;
        } ?>
    </div>
</div>

<?php include 'page/footer.php'; ?>