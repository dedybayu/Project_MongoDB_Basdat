<?php
require '../config/auth.php'; // Pastikan admin login
include 'page/header.php';

?>

<div class="container">
    <h1 class="my-4">Selamat Datang, <?= $_SESSION['admin_username'] ?></h1>
    <a href="add_news.php" class="btn btn-primary">Tambah Berita</a>
    <a href="manage_news.php" class="btn btn-secondary">Kelola Berita</a>
    <a href="logout.php" class="btn btn-danger">Logout</a>
</div>


<?php
include 'page/footer.php';
?>