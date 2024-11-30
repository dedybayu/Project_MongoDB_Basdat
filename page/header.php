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