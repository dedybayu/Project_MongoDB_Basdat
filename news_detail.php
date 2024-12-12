<?php
require 'config/database.php';

// Get the article ID from the URL and convert it to MongoDB ObjectId
$id = new MongoDB\BSON\ObjectId($_GET['id']);

// Increment the view count (jumlah_views) by 1
$newsCollection->updateOne(
    ['_id' => $id], // Find the article by ID
    ['$inc' => ['jumlah_views' => 1]] // Increment the jumlah_views field by 1
);

// Fetch the article data
$article = $newsCollection->findOne(['_id' => $id]);

// Access the comments collection from the database
$commentsCollection = $db->comments; // Correct way to access the 'comments' collection

// Fetch comments for the current article
$commentsCursor = $commentsCollection->find(['id_news' => $id]);

// Convert cursor to an array to avoid 'rewind' issue
$comments = iterator_to_array($commentsCursor);

// Process comment submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment'])) {
    // Ensure that the comment is not empty
    if (!empty($_POST['comment'])) {
        // Insert new comment into the comments collection
        $commentsCollection->insertOne([
            'id_news' => $id,
            'comment' => $_POST['comment'],
            'created_at' => new MongoDB\BSON\UTCDateTime() // Store the current timestamp
        ]);

        // Reload the page to show the new comment
        header("Location: {$_SERVER['REQUEST_URI']}");
        exit;
    }
}

include 'page/header-user.php';
?>


<!-- Main News Slider Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between bg-transparent py-2 px-0 mb-3">
                            <h3 class="m-0"><?= htmlspecialchars($article['title']) ?></h3>
                        </div>
                    </div>
                    
                    <div class="col-lg-12">
                        <div class="position-relative mb-3">
                            <?php if (isset($article['image'])): ?>
                                <img class="img-fluid w-100" src="data:image/jpeg;base64,<?= base64_encode($article['image']->getData()) ?>" alt="Gambar Berita"
                                    style="object-fit: cover; width: 100%; height: 500px; margin-bottom: 20px;">
                            <?php endif; ?>
                            <div class="overlay position-relative bg-light">
                                <div class="mb-2" style="font-size: 14px;">
                                    <a href="view_kategori.php?category=<?= $article['category']?>"><?php echo $article['category']; ?></a>
                                    <span class="px-1">/</span>
                                    <a><?php
                                    // Ambil waktu yang disimpan di MongoDB (dalam UTC)
                                    $createdAt = $article['created_at']->toDateTime();

                                    // Set zona waktu ke WIB (Asia/Jakarta)
                                    $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));

                                    // Tampilkan waktu dalam format yang diinginkan (d-m-Y H:i)
                                    echo $createdAt->format('d-m-Y');
                                    ?></a>
                                </div>
                                <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4">
                <!-- Tambahkan komentar di sini -->
                <h4>Komentar:</h4>
                <?php if (count($comments) == 0): ?>
                    <p>Belum ada komentar.</p>
                <?php else: ?>
                    <?php foreach ($comments as $comment): ?>
                        <div class="comment">
                            <p><?= htmlspecialchars($comment['comment']) ?></p>
                            <p><small>Ditambahkan pada:
                                    <?php
                                    $createdAt = $comment['created_at']->toDateTime();
                                    $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                                    echo $createdAt->format('d-m-Y H:i');
                                    ?>
                                </small></p>
                            <hr>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

                <!-- Form komentar -->
                <br>
                <h4>Tambahkan Komentar:</h4>
                <form action="" method="post">
                    <div class="form-group">
                        <textarea name="comment" class="form-control" rows="3" required></textarea </div><br>
                    <button type="submit" class="btn btn-primary">Kirim Komentar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'page/footer-user.php'; ?>