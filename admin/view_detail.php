<?php
require '../config/database.php';

// Get the article ID from the URL and convert it to MongoDB ObjectId
$id = new MongoDB\BSON\ObjectId($_GET['id']);

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

// Handle comment deletion
if (isset($_GET['delete_comment_id'])) {
    $deleteCommentId = new MongoDB\BSON\ObjectId($_GET['delete_comment_id']);
    
    // Delete the comment from the comments collection
    $commentsCollection->deleteOne(['_id' => $deleteCommentId]);

    // Redirect back to the article page
    header("Location: ../admin/view_detail.php?id=$id");
    exit;
}

include 'page/header.php';
?>

<div class="container">
    <h1 class="my-4"><?= htmlspecialchars($article['title']) ?></h1>
    <p><strong>Penulis:</strong> <?= htmlspecialchars($article['author']) ?></p>
    <p><strong>Kategori:</strong> <?= htmlspecialchars($article['category']) ?></p>
    <p><strong>Diterbitkan:</strong>
        <?php
        // Format the created_at timestamp to Jakarta timezone
        $createdAt = $article['created_at']->toDateTime();
        $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
        echo $createdAt->format('d-m-Y H:i');
        ?>
    </p>
    <hr>

    <!-- Display image inside paragraph with content wrapping -->
    <div class="content-box mt-0 responsive-content">
        <?php if (isset($article['image'])): ?>
            <div class="image-text-container">
                <img src="data:image/jpeg;base64,<?= base64_encode($article['image']->getData()) ?>" alt="Gambar Berita" 
                    class="responsive-image">
                <p class="text-content">
                    <?= nl2br(htmlspecialchars($article['content'])) ?>
                </p>
            </div>
        <?php else: ?>
            <p class="text-content"><?= nl2br(htmlspecialchars($article['content'])) ?></p>
        <?php endif; ?>
    </div>
    
    <!-- Tambahkan CSS -->
    <style>
        .responsive-content {
            margin-bottom: 20px;
        }

        .image-text-container {
            text-align: center; /* Memastikan gambar berada di tengah */
        }

        .text-content {
            line-height: 1.6; /* Meningkatkan keterbacaan teks */
            margin: 0;
            text-align: justify; /* Teks rata kanan dan kiri */
        }

        .responsive-image {
            display: block;
            margin: 0 auto 20px; /* Tengahkan gambar dan beri jarak bawah */
            max-width: 70%; /* Batasi ukuran gambar hingga 80% dari lebar container */
            height: auto; /* Pertahankan ukuran gambar */
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
        }
    </style>

    <!-- Display view count below the content -->
    <p><strong>Jumlah Views:</strong> <?= isset($article['jumlah_views']) ? $article['jumlah_views'] : 0 ?></p>

    <hr>
    <!-- Display existing comments -->
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
                <!-- Delete Comment Button -->
                <a href="?id=<?= $article['_id'] ?>&delete_comment_id=<?= $comment['_id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">Hapus</a>
                <hr>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- Comment Form -->
    <br>
    <h4>Tambahkan Komentar:</h4>
    <form action="" method="post">
        <div class="form-group">
            <textarea name="comment" class="form-control" rows="3" required></textarea>
        </div><br>
        <button type="submit" class="btn btn-primary">Kirim Komentar</button>
    </form>
    <!-- Tombol Edit dan Hapus -->
    <div class="mt-4">
        <a href="edit_news.php?id=<?= $article['_id'] ?>" class="btn btn-primary">Edit</a>
        <a href="delete_news.php?id=<?= $article['_id'] ?>" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">Hapus</a>
    </div>
</div>

<?php
include 'page/footer.php';
?>
