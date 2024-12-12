<?php
require 'config/database.php';

$category = $_GET['category'];
if ($category === '') {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

$cursor = $newsCollection->find(
    ['category' => $category],
    ['projection' => ['title' => 1, 'summary' => 1, 'created_at' => 1, 'category' => 1, 'image' => 1]]
);

$results = iterator_to_array($cursor);

include 'page/header-user.php';
?>


<!-- Breadcrumb Start -->
<div class="col-lg-2"></div>
    <div class="container-fluid col-lg-8">
        <div class="container">
            <nav class="breadcrumb bg-transparent m-0 p-0">
                <a class="breadcrumb-item" href="index.php">Home</a>
    
                <span class="breadcrumb-item active">Kategori <?= $category ?></span>
            </nav>
        </div>
    </div>
    <!-- Breadcrumb End -->

    
    <!-- News With Sidebar Start -->
    <div class="container-fluid py-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex align-items-center justify-content-between bg-light py-2 px-4 mb-3">
                                <h3 class="m-0">Hasil Pencarian Kategori "<?= $category ?>"</h3>
                            </div>
                        </div>
                        
                        <?php
                        if (count($results) === 0) {
                            
                            echo "<div class='col-lg-12'><p class='text-center mt-5'>Maaf tidak ada hasil pencarian untuk kategori '" . htmlspecialchars($category) . "'</p></div>";
                            
                        } else {
                            foreach ($results as $article): ?>
                                <div class="col-lg-6">
                                    <div class="position-relative mb-3">
                                    <img class="img-fluid w-100" src="data:image/jpeg;base64,<?= base64_encode($article['image']->getData()) ?>" style="object-fit: cover; width: 500px; height: 280px;"> 
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
                                            <a class="h4" href="news_detail.php?id=<?= $article['_id'] ?>"><?= $article['title'] ?></a>
                                            <p class="m-0"><?= $article['summary'] ?> </p>
                                        </div>
                                    </div>
                                </div>

                        <?php endforeach; } ?>
                    </div>
          
                </div>

                <div class="col-lg-4 pt-3 pt-lg-0">
                    

                <!-- Trending News Start -->
<div class="pb-3">
    <?php
    $newsTrending = $newsCollection->find([], [
        'sort' => ['jumlah_views' => -1]  // Sort by 'jumlah_views' in descending order
    ]);
    ?>
    <div class="bg-light py-2 px-4 mb-3">
        <h3 class="m-0">Trending</h3>
    </div>
    <!-- Tambahkan container dengan scrolling -->
    <div style="max-height: 400px; overflow-y: auto;">
        <?php foreach ($newsTrending as $article): ?>
            <div class="d-flex mb-3">
                <img src="data:image/jpeg;base64,<?= base64_encode($article['image']->getData()) ?>"
                    style="width: 100px; height: 100px; object-fit: cover;">
                <div class="w-75 d-flex flex-column justify-content-center bg-light px-3"
                    style="height: 100px;">
                    <div class="mb-1" style="font-size: 13px;">
                        <a href="view_kategori.php?category=<?= $article['category']?>"><?php echo $article['category']; ?></a>
                        <span class="px-1">/</span>
                        <span><?php
                        // Ambil waktu yang disimpan di MongoDB (dalam UTC)
                        $createdAt = $article['created_at']->toDateTime();

                        // Set zona waktu ke WIB (Asia/Jakarta)
                        $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));

                        // Tampilkan waktu dalam format yang diinginkan (d-m-Y H:i)
                        echo $createdAt->format('d-m-Y');
                        ?></span>
                    </div>
                    <a class="h6 m-0" href="news_detail.php?id=<?= $article['_id'] ?>"><?= $article['title'] ?></a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Trending News End -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- News With Sidebar End -->

<?php include 'page/footer-user.php'; ?>