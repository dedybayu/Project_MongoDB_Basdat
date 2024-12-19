<?php
require '../config/database.php';

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

include 'page/header-admin.php';
?>

<!-- Breadcrumb Start -->
<div class="col-lg-2"></div>
<div class="container-fluid col-lg-8">
    <div class="container">
        <nav class="breadcrumb bg-transparent m-0 p-0">
            <a class="breadcrumb-item" href="#">Home</a>
            <a class="breadcrumb-item"
                href="view_kategori.php?category=<?= $article['category'] ?>"><?php echo $article['category']; ?></a>
            <span class="breadcrumb-item active"><?= $article['title'] ?></span>
        </nav>
    </div>
</div>
<!-- Breadcrumb End -->


<!-- News With Sidebar Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <!-- News Detail Start -->
                <div class="position-relative mb-3">

                    <div class=" overlay position-relative bg-light ">

                        <div class=" w-100">
                            <div style=" display: flex; justify-content: space-between;">
                                <div class="info">
                                    <a
                                        href="view_kategori.php?category=<?= $article['category'] ?>"><?php echo $article['category']; ?></a>
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
                                <div>
                                    <span><?= $article['author'] ?></span>
                                </div>

                            </div>
                            <div class="w-100 ">
                                <h3 class="mb-3"><?= $article['title'] ?></h3>
                                <div class="content-box mt-0 responsive-content">
                                    <?php if (isset($article['image'])): ?>
                                        <div class="content image-text-container">
                                            <p class="text-content">
                                                <img src="data:image/jpeg;base64,<?= base64_encode($article['image']->getData()) ?>"
                                                    style="object-fit: cover; width: 500px; height: 280px;
                                            alt=" Gambar Berita"
                                                    class="img-fluid w-50 float-left mr-4 mb-2 responsive-image size-<?= isset($article['image_size']) ? htmlspecialchars($article['image_size']) : 'medium' ?>">
                                                <!-- Menambahkan class dinamis -->
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
                                        overflow: hidden;
                                        /* Pastikan elemen tidak meluap */
                                    }

                                    .text-content {
                                        line-height: 1.6;
                                        margin: 0;
                                        text-align: justify;
                                    }

                                    .responsive-image {
                                        float: left;
                                        margin: 0 20px 20px 0;
                                        border-radius: 8px;
                                        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                        object-fit: contain;
                                        /* Menjaga rasio gambar dengan menyelaraskan ukuran gambar */
                                        width: 100%;
                                        height: 100%;
                                    }

                                    /* Ukuran gambar yang diatur ke 500px x 500px */
                                    .responsive-image.size-small {
                                        width: 100%;
                                        height: 100%;
                                        max-width: 500px;
                                        max-height: 500px;
                                    }

                                    .responsive-image.size-medium {
                                        width: 100%;
                                        height: 100%;
                                        max-width: 500px;
                                        max-height: 500px;
                                    }

                                    @media (max-width: 768px) {
                                        .responsive-image {
                                            float: none;
                                            /* Hilangkan float di layar kecil */
                                            display: block;
                                            /* Gambar berada di atas teks */
                                            margin: 0 auto 20px;
                                            /* Tengahkan gambar dan beri jarak bawah */
                                            max-width: 100%;
                                            /* Sesuaikan dengan lebar layar */
                                        }
                                    }
                                </style>
                            </div>
                        </div>
                    </div>
                    <!-- News Detail End -->

                    
                     <!-- Comment List Start -->
<div class="bg-light mb-3" style="padding: 30px;">
    <h3 class="mb-3">
        <?= isset($comments) ? count($comments) : 0 ?> Komentar
                        </h3>
                        <?php if (empty($comments) || count($comments) === 0): ?>
                            <p>Belum ada komentar.</p>
                        <?php else: ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="media mb-2">
                                    <img src="../assets/img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px;">
                                    <div class="media-body">
                                        <h6 class="d-flex justify-content-between">
                                            <a href="#">Anonim</a>
                                            <small class="text-end">
                                                <i>Ditambahkan pada:
                                                    <?php
                                                    if (isset($comment['created_at'])) {
                                                        $createdAt = $comment['created_at']->toDateTime();
                                                        $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                                                        echo $createdAt->format('d-m-Y H:i');
                                                    } else {
                                                        echo 'Tanggal tidak tersedia';
                                                    }
                                                    ?>
                                                </i>
                                            </small>
                                        </h6>
                                        <p>
                                            <?= isset($comment['comment']) ? htmlspecialchars($comment['comment']) : 'Komentar tidak tersedia' ?>
                                        </p>
                                        <div class="d-flex justify-content-end">
                                            <a href="edit_news.php?id=<?= isset($comment['_id']) ? $comment['_id'] : '#' ?>"
                                                class="btn btn-sm btn-warning mr-2">Edit</a>
                                            <a href="delete_news.php?id=<?= isset($comment['_id']) ? $comment['_id'] : '#' ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">Hapus</a>
                                        </div>
                                        <hr>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                    <!-- Comment List End -->

                    <!-- Comment Form Start -->
                    <div class="bg-light mb-3" style="padding: 30px;">
                        <h3 class="mb-4">Tambahkan Komentar</h3>
                        <form action="#message" method="post">

                            <div class="form-group">
                                <label for="message">Komentar *</label>
                                <textarea name="comment" id="message" cols="30" rows="3" class="form-control"
                                    required></textarea>
                            </div>
                            <div class="form-group mb-0">
                                <input type="submit" value="Kirim Komentar"
                                    class="btn btn-primary font-weight-semi-bold py-2 px-3">
                            </div>
                        </form>
                    </div>
                    <!-- Comment Form End -->
                </div>

                <div class="col-lg-2 pt-3 pt-lg-0">



                </div>
            </div>
        </div>
    </div>
</div>
<!-- News With Sidebar End -->

<?php
include 'page/footer-admin.php';
?>