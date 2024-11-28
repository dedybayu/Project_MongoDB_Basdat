<?php
require '../config/auth.php'; // Pastikan admin login
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h1 class="my-4">Selamat Datang, <?= $_SESSION['admin_username'] ?></h1>
    <a href="add_news.php" class="btn btn-primary">Tambah Berita</a>
    <a href="manage_news.php" class="btn btn-secondary">Kelola Berita</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>
</body>
</html>
