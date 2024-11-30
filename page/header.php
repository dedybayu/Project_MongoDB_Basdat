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
    <nav class="navbar">
        <div class="navbar-container">
            <a href="#" class="navbar-brand">Berita.com</a>
            <ul class="navbar-links">
                <li><a href="admin/login.php">Login</a></li>
            </ul>
        </div>
    </nav>

    <!-- Sidebar -->
    <div class="sidebar">
        <ul class="sidebar-links list-unstyled">
            <li><a href="index.php" class="text-decoration-none">Dashboard</a></li>
            <li class="category">
                <a href="#submenuKategori"
                    class="category-link text-decoration-none d-flex justify-content-between align-items-center"
                    data-bs-toggle="collapse" aria-expanded="false">
                    Kategori
                    <span class="icon">
                        <i class="fa fa-chevron-down"></i> <!-- Panah ke bawah -->
                    </span>
                </a>
                <ul class="collapse list-unstyled ms-3" id="submenuKategori">
                    <li><a href="#" class="text-decoration-none">Teknologi</a></li>
                    <li><a href="#" class="text-decoration-none">Politik</a></li>
                    <li><a href="#" class="text-decoration-none">Pendidikan</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="container">
        <h1 class="my-4">Berita Terkini</h1>
        <form action="search.php" method="get" class="mb-4">
            <input type="text" name="q" class="form-control" placeholder="Cari berita...">
        </form>