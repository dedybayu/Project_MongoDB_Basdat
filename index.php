<?php
include 'page/header-user.php';
?>

<!-- Main News Slider Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="owl-carousel owl-carousel-2 carousel-item-1 position-relative mb-3 mb-lg-0">
                    <?php foreach ($news as $article): ?>

                        <div class="position-relative overflow-hidden" style="height: 435px;">
                            <img class="img-fluid h-100"
                                src="data:image/jpeg;base64,<?= base64_encode($article['image']->getData()) ?>"
                                style="object-fit: cover;">
                            <div class="overlay">
                                <div class="mb-1 w-100" style="font-weight: 500; font-size: 19px;">
                                <a class="text-white" href="view_kategori.php?category=<?= $article['category']?>"><?php echo $article['category']; ?></a>
                                    <span class="px-2 text-white">/</span>
                                    <span class="text-white"><?php
                                    // Ambil waktu yang disimpan di MongoDB (dalam UTC)
                                    $createdAt = $article['created_at']->toDateTime();

                                    // Set zona waktu ke WIB (Asia/Jakarta)
                                    $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));

                                    // Tampilkan waktu dalam format yang diinginkan (d-m-Y H:i)
                                    echo $createdAt->format('d-m-Y');
                                    ?></span>
                                    
                                    <span class="text-white" style="float: right;">Views:
                                        <?= isset($article['jumlah_views']) ? $article['jumlah_views'] : 0 ?></span>
                                </div>
                                <a class="h2 m-0 text-white font-weight-bold" style="font-size: 31px; font-style: roboto, sans-serif;  hover: underline;"
                                    href="news_detail.php?id=<?= $article['_id'] ?>"><?= $article['title'] ?></a>
                            </div>
                        </div>

                    <?php endforeach; ?>

                </div>
            </div>
            
            <div class="col-lg-4">

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
<!-- Main News Slider End -->

<!-- Latest Start -->
<div class="container-fluid py-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="d-flex align-items-center justify-content-between bg-light py-2 px-4 mb-3">
                            <h3 class="m-0">Terbaru</h3>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <?php
                        // Konfigurasi paginasi
                        $articlesPerPage = 7;
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $skip = ($currentPage - 1) * $articlesPerPage;

                        // Hitung total artikel
                        $totalArticles = $newsCollection->countDocuments();
                        $totalPages = ceil($totalArticles / $articlesPerPage);

                        // Ambil data artikel berdasarkan halaman
                        $news2 = $newsCollection->find([], [
                            'sort' => ['created_at' => -1],
                            'skip' => $skip,
                            'limit' => $articlesPerPage
                        ]);

                        foreach ($news2 as $article):
                        ?>
                            <div class="d-flex mb-3">
                                <img src="data:image/jpeg;base64,<?= base64_encode($article['image']->getData()) ?>"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                                <div class="w-100 d-flex flex-column justify-content-center bg-light px-3"
                                    style="height: 100px;">
                                    <div class="mb-1" style="font-size: 13px;">
                                        <a href="view_kategori.php?category=<?= $article['category']?>"><?php echo $article['category']; ?></a>
                                        <span class="px-1">/</span>
                                        <span><?php
                                        // Ambil waktu yang disimpan di MongoDB (dalam UTC)
                                        $createdAt = $article['created_at']->toDateTime();
                                        $createdAt->setTimezone(new DateTimeZone('Asia/Jakarta'));
                                        echo $createdAt->format('d-m-Y H:i');
                                        ?></span>
                                    </div>
                                    <a class="h6 m-0"
                                        href="news_detail.php?id=<?= $article['_id'] ?>"><?= $article['title'] ?></a>
                                </div>
                            </div>
                        <?php endforeach; ?>

                        <!-- Navigasi Paginasi -->
                        <div class="d-flex justify-content-center mt-3">
                            <nav>
                                <ul class="pagination">
                                    <?php if ($currentPage > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?= $currentPage - 1 ?>">Previous</a>
                                        </li>
                                    <?php endif; ?>

                                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                        <li class="page-item <?= ($i == $currentPage) ? 'active' : '' ?>">
                                            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <?php if ($currentPage < $totalPages): ?>
                                        <li class="page-item">
                                            <a class="page-link" href="?page=<?= $currentPage + 1 ?>">Next</a>
                                        </li>
                                    <?php endif; ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 pt-3 pt-lg-0">
            </div>
        </div>
    </div>
</div>
<!-- Latest End -->


<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Pilih semua tautan kategori yang memiliki kelas 'category-link'
        const categoryLinks = document.querySelectorAll('.category-link');

        categoryLinks.forEach(link => {
            link.addEventListener('click', (e) => {
                e.preventDefault(); // Mencegah default aksi tautan
                const parentLi = link.parentElement; // Ambil elemen <li> induk
                parentLi.classList.toggle('open'); // Menambahkan / menghapus kelas 'open'
            });
        });
    });
</script>

<?php
include 'page/footer-user.php';
?>