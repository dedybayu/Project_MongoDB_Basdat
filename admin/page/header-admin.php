<?php
require '../config/database.php';
$news = $newsCollection->find([], ['sort' => ['created_at' => -1]]);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>KataData </title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="../css/style-user.css" rel="stylesheet">
    
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center bg-light px-lg-5">

        </div>
        <div class="row align-items-center py-2 px-lg-5">
            <div class="col-lg-4">
                <a href="dashboard.php" class="navbar-brand d-none d-lg-block">
                    <h1 class="m-0 display-5 text-uppercase"><span class="text-primary">Kata</span>Data</h1>
                </a>
            </div>
            <div class="navbar navbar-expand-lg py-1 py-lg-0 px-lg-7 input-group ml-auto"
                style="width: 100%; max-width: 350px;">
                <div class="collapse navbar-collapse px-0 px-lg-1">
                    <a href="../index.php" class=" nav-item nav-link active">Logout</a>
                    <form action="search.php" method="get">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Cari berita...">
                            <div class="input-group-append">
                                <button class="input-group-text text-secondary ml-2" type="submit"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            

        </div>

    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <div class="container-fluid p-0 mb-3">
        <nav class="navbar navbar-expand-lg bg-light navbar-light py-2 py-lg-0 px-lg-5">
            <a href="dashboard.php" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 display-5 text-uppercase"><span class="text-primary">Kata</span>Data</h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
                <div class="col-lg-1"></div>
                <div class="navbar-nav mr-auto py-0" id="navbar">
                    <a href="dashboard.php" class="nav-item nav-link  ">Home</a>
                    <a href="trending.php" class="nav-item nav-link">Trending</a>

                    <a href="view_kategori.php?category=Teknologi" class="nav-item nav-link ">Teknologi</a>
                    <a href="view_kategori.php?category=Politik" class="nav-item nav-link">Politik</a>
                    <a href="view_kategori.php?category=Pendidikan" class="nav-item nav-link">Pendidikan</a>
                    <a href="view_kategori.php?category=Kesehatan" class="nav-item nav-link">Kesehatan</a>
                    <a href="view_kategori.php?category=Hiburan" class="nav-item nav-link">Hiburan</a>
                    <a href="view_kategori.php?category=Olahraga" class="nav-item nav-link">Olahraga</a>
                    <a href="view_kategori.php?category=Kriminal" class="nav-item nav-link">Kriminal</a>
                    <a href="view_kategori.php?category=Lingkungan" class="nav-item nav-link">Lingkungan</a>
                    <a href="view_kategori.php?category=Lainnya" class="nav-item nav-link">Lainnya</a>

                     <a href="add_news.php" class="nav-item nav-link">Tambah Berita</a>
                    <a href="manage_news.php" class="nav-item nav-link">Kelola Berita</a>
                    <a href="change_password" class="nav-item nav-link">Ubah Password</a>
            


                </div>

                <script>
                    // Tunggu sampai seluruh konten DOM selesai dimuat
                    document.addEventListener('DOMContentLoaded', () => {
                        // mengammbil semua elemen dengan kelas 'nav-link'
                        const links = document.querySelectorAll('.nav-link');
                        const currentPath = window.location.pathname; // Ambil path saat ini

                        // memeriksa setiap tautan untuk menyesuaikan dengan URL saat ini
                        links.forEach(link => {
                            //  href tautan sesuai dengan URL saat ini (path atau URL penuh), menambahkan kelas 'active'
                            if (link.getAttribute('href') === currentPath || currentPath.includes(link.getAttribute('href'))) {
                                link.classList.add('active');
                            } else {
                                link.classList.remove('active');
                            }
                        });
                    });
                </script>

            </div>
        </nav>
    </div>


    <!-- Navbar End -->