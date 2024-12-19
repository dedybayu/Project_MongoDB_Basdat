<?php
require 'config/database.php';
$news = $newsCollection->find([], ['sort' => ['created_at' => -1]]);

// Menghitung jumlah notifikasi yang belum dibaca
$totalUnreadNotifications = $notificationsCollection->countDocuments(['status' => 'unread']);

// Mengambil daftar notifikasi dengan urutan terbaru terlebih dahulu
$recentNotifications = $notificationsCollection->find([], ['sort' => ['created_at' => -1]]);


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
    <link href="css/style-user-admin.css" rel="stylesheet">
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row align-items-center bg-light px-lg-5">

        </div>
        <div class="row align-items-center py-2 px-lg-5">
            <div class="col-lg-4">
                <a href="index.php" class="navbar-brand d-none d-lg-block">
                    <h1 class="m-0 display-5 text-uppercase"><span class="text-primary">Kata</span>Data</h1>
                </a>
            </div>
            <div class="navbar navbar-expand-lg py-1 py-lg-0 px-lg-7 input-group ml-auto"
                style="width: 100%; max-width: 350px;">

                <div class="collapse navbar-collapse notification-wrapper">
                    <button id="notification-button" class="btn btn-primary position-relative">
                        <i class="fa fa-bell"></i>
                        <span id="notification-count"
                            class="position-absolute top-0 start-100 translate-middle badge rounded-pill"
                            style="display: none;">
                            <?= $notificationCount ?>
                        </span>
                    </button>

                    <!-- Dropdown untuk notifikasi -->
                    <div id="notification-list" class="dropdown-menu dropdown-menu-left mt-2 p-2"
                        style="display: none; width: 390px;">
                        <div id="notification-content">
                            <?php foreach ($notifications as $notification): ?>
                                <div class="dropdown-item bg-light mb-2 rounded p-2"
                                    id="notification-<?= $notification['_id'] ?>">
                                    <p class="notification-message"><?= $notification['message'] ?></p>
                                    <small
                                        class="text-muted"><?= $notification['created_at']->toDateTime()->format('d M Y, H:i') ?></small>
                                    <button class="btn btn-danger btn-sm float-right delete-notification"
                                        data-id="<?= $notification['_id'] ?>">Delete</button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <style>
                        .notification-message {
                            white-space: normal;
                            /* Allow text to wrap */
                            word-wrap: break-word;
                            /* Break long words */
                            overflow: hidden;
                            /* Hide overflow */
                            text-overflow: ellipsis;
                            /* Add ellipsis if text overflows */
                        }
                    </style>


                </div>

                <div class="collapse navbar-collapse px-0 px-lg-1">
                    <a href="admin/login.php" class=" nav-item nav-link active">Login</a>
                    <form action="search.php" method="get">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Cari berita...">
                            <div class="input-group-append">
                                <button class="input-group-text text-secondary ml-2" type="submit"><i
                                        class="fa fa-search"></i></button>
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
            <a href="index.php" class="navbar-brand d-block d-lg-none">
                <h1 class="m-0 display-5 text-uppercase"><span class="text-primary">Kata</span>Data</h1>
            </a>
            <!-- Wrapper untuk Toggler dan Notifikasi -->
            <div class="d-flex align-items-center d-lg-none">
                <!-- Tombol Toggler -->
                <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                    <div><span class="navbar-toggler-icon"></span></div>
                </button>


            </div>

            <div class="collapse navbar-collapse justify-content-between px-0 px-lg-3" id="navbarCollapse">
                <div class="col-lg-1"></div>
                <div class="navbar-nav mr-auto py-0" id="navbar">
                    <a href="index.php" class="nav-item nav-link  ">Home</a>
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


                </div>

                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        // Add event listener to all delete buttons
                        const deleteButtons = document.querySelectorAll('.delete-notification');

                        deleteButtons.forEach(button => {
                            button.addEventListener('click', function () {
                                const notificationId = this.getAttribute('data-id');
                                const notificationElement = document.getElementById('notification-' + notificationId);

                                // Make the AJAX request to delete the notification
                                fetch('delete_notification.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/x-www-form-urlencoded',
                                    },
                                    body: 'id=' + notificationId
                                })
                                    .then(response => response.text())
                                    .then(data => {
                                        // If deletion was successful, remove the notification from the dropdown
                                        if (data.includes('Notification deleted successfully')) {
                                            notificationElement.remove();
                                        } else {
                                            alert('Error deleting notification');
                                        }
                                    })
                                    .catch(error => {
                                        console.error('Error:', error);
                                        alert('Error deleting notification');
                                    });
                            });
                        });
                    });


                    // Tunggu sampai seluruh konten DOM selesai dimuat
                    document.addEventListener('DOMContentLoaded', () => {
                        // Mengambil semua elemen dengan kelas 'nav-link'
                        const links = document.querySelectorAll('.nav-link');
                        const currentLocation = window.location.href; // Ambil URL lengkap saat ini

                        // Memeriksa setiap tautan untuk menyesuaikan dengan URL saat ini
                        links.forEach(link => {
                            const linkHref = link.getAttribute('href'); // Mendapatkan href dari link
                            // Menambahkan kelas 'active' jika URL saat ini sesuai dengan href link
                            if (currentLocation.includes(linkHref)) {
                                link.classList.add('active');
                            } else {
                                link.classList.remove('active');
                            }
                        });
                    });


                    document.getElementById('notification-button').addEventListener('click', () => {
                        const notificationList = document.getElementById('notification-list');
                        notificationList.style.display = notificationList.style.display === 'none' ? 'block' : 'none';

                        // Tandai notifikasi sebagai dibaca
                        fetch('update_notifications.php', {
                            method: 'POST'
                        }).then(() => {
                            // Menyembunyikan angka notifikasi ketika sudah dibaca
                            const notificationCount = document.getElementById('notification-count');
                            notificationCount.textContent = '';
                            notificationCount.classList.remove('bg-info');
                        });
                    });

                    setInterval(() => {
                        // Ambil jumlah notifikasi
                        fetch('get_notification_count.php')
                            .then(response => response.json())
                            .then(data => {
                                const notificationCount = document.getElementById('notification-count');
                                if (data.count > 0) {
                                    // Menampilkan angka dan warna jika ada notifikasi
                                    notificationCount.textContent = data.count;
                                    notificationCount.classList.add('bg-info');
                                    notificationCount.style.display = 'inline'; // Menampilkan angka
                                } else {
                                    // Menyembunyikan angka dan warna jika tidak ada notifikasi
                                    notificationCount.textContent = '';
                                    notificationCount.classList.remove('bg-info');
                                    notificationCount.style.display = 'none'; // Menyembunyikan angka dan warna
                                }
                            });

                        // Ambil notifikasi terbaru
                        fetch('get_notification.php')
                            .then(response => response.json())
                            .then(notifications => {
                                const notificationContent = document.getElementById('notification-content');

                                // Masukkan notifikasi baru ke dalam daftar, di bagian atas
                                if (notifications.length > 0) {
                                    notifications.forEach(notification => {
                                        const notificationItem = document.createElement('div');
                                        notificationItem.classList.add('dropdown-item', 'bg-light', 'mb-2', 'rounded', 'p-2');
                                        notificationItem.innerHTML = `
                    <p>${notification.message}</p>
                    <small class="text-muted">${notification.created_at}</small>
                `;
                                        // Menambahkan notifikasi baru di atas daftar
                                        notificationContent.prepend(notificationItem);
                                    });
                                }
                            });
                    }, 3000); // Interval setiap 3 detik


                </script>

            </div>
        </nav>
    </div>

    <style>
        /* Wrapper untuk tombol toggler dan notifikasi */
        .d-flex.align-items-center {
            gap: 0.5rem;
            /* Jarak antara tombol */
        }

        /* Atur ukuran dan jarak untuk tombol notifikasi */
        #notification-button {
            padding: 5px 10px;
            /* Ukuran tombol lebih kecil */
            margin-left: 5px;
            /* Tambahkan sedikit jarak di kiri */
        }

        /* Responsif untuk layar kecil */
        @media (max-width: 992px) {
            .navbar-toggler {
                margin-right: 0;
                /* Hilangkan margin default */
            }

            #notification-button {
                margin-left: 0;
                /* Dekatkan tombol notifikasi */
            }
        }
    </style>


    <!-- Navbar End -->