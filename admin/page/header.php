<?php
require '../config/database.php';
$news = $newsCollection->find([], ['sort' => ['created_at' => -1]]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Terkini</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">

</head>

<body>
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
            <a href="dashboard.php" class="navbar-brand">KataData</a>
        </div>
    </nav>


    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-links list-unstyled">
            <li><a href="dashboard.php" class="text-decoration-none">Dashboard</a></li>
            <li><a href="add_news.php" class="text-decoration-none">Tambah Berita</a></li>
            <li><a href="manage_news.php" class="text-decoration-none">Kelola Berita</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <script>
        // Menangani klik tombol toggle pada sidebar
        document.querySelector('.toggle-sidebar').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('open');
        });
    </script>