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
    <!-- Navbar -->
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" class="navbar-brand toggle-sidebar">
                <div class="hamburger-menu">
                    <div class="line"></div>
                    <div class="line"></div>
                    <div class="line"></div>
                </div>
            </a>
            <a href="index.php" class="navbar-brand">KataData</a>
        </div>
    </nav>


    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-links list-unstyled">
            <li><a href="index.php" class="text-decoration-none">Dashboard</a></li>
            <li><a href="trending.php" class="text-decoration-none">Trending</a></li>
            <li class="category">
                <a href="#submenuKategori"
                    class="category-link text-decoration-none d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" aria-expanded="false">
                    Kategori
                    <span class="icon">
                        <i class="fa fa-chevron-down"></i>
                    </span>
                </a>
                <ul class="collapse list-unstyled ms-3" id="submenuKategori">
                <li><a href="view_kategori.php?category=Teknologi" class="text-decoration-none">Teknologi</a></li>
                <li><a href="view_kategori.php?category=Politik" class="text-decoration-none">Politik</a></li>
                <li><a href="view_kategori.php?category=Pendidikan" class="text-decoration-none">Pendidikan</a></li>
                <li><a href="view_kategori.php?category=Kesehatan" class="text-decoration-none">Kesehatan</a></li>
                <li><a href="view_kategori.php?category=Hiburan" class="text-decoration-none">Hiburan</a></li>
                <li><a href="view_kategori.php?category=Olahraga" class="text-decoration-none">Olahraga</a></li>
                <li><a href="view_kategori.php?category=Kriminal" class="text-decoration-none">Kriminal</a></li>
                <li><a href="view_kategori.php?category=Lingkungan" class="text-decoration-none">Lingkungan</a></li>
                <li><a href="view_kategori.php?category=Lainnya" class="text-decoration-none">Lainnya</a></li>
            </ul>
            </li>
            <li><a href="admin/login.php">Login</a></li>
        </ul>
    </div>

    <script>
        // Menangani klik tombol toggle pada sidebar
        document.querySelector('.toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('open');
        });
    </script>