<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Cek jika sesi change_password tidak ada atau bernilai false
if (!isset($_SESSION['change_password']) || !$_SESSION['change_password']) {
    header('Location: ../../admin/dashboard.php');
    exit;
}

require '../../config/database.php'; // Menggunakan koneksi dari database.php

$username_saatIni = $_SESSION['change_password_username'];

// Variabel untuk pesan kesalahan
$error_message = "";

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pilih koleksi users
    $usersCollection = $db->users;

    // Data dari form
    $newUsername = trim($_POST['new_username']);
    $newPassword = trim($_POST['new_password']);

    // Validasi input
    if (strlen($newPassword) < 5) {
        $error_message = "Password harus memiliki minimal 5 karakter.";
    } else {
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        try {
            // Cek apakah pengguna ada
            $existingUser = $usersCollection->findOne(['username' => $username_saatIni]);

            if ($existingUser) {
                // Update username dan password pengguna
                $updateData = [];

                if (!empty($newUsername) && $newUsername !== $username_saatIni) {
                    $updateData['username'] = $newUsername;
                }
                $updateData['password'] = $hashedPassword;

                $updateResult = $usersCollection->updateOne(
                    ['username' => $username_saatIni],
                    ['$set' => $updateData]
                );

                if ($updateResult->getModifiedCount() > 0) {
                    unset($_SESSION['change_password']);
                    unset($_SESSION['change_password_username']);
                    echo "<script>
                        alert('Data untuk pengguna berhasil diperbarui!');
                        window.location.href = '../../admin/dashboard.php';
                    </script>";
                    if (isset($updateData['username'])) {
                        $_SESSION['change_password_username'] = $newUsername;
                    }
                } else {
                    $error_message = "Tidak ada perubahan data.";
                }
            } else {
                $error_message = "Pengguna dengan username '$username_saatIni' tidak ditemukan.";
            }
        } catch (Exception $e) {
            $error_message = "Terjadi kesalahan saat mengupdate data: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Username and Password</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background: #f4f7fc;
            font-family: 'Arial', sans-serif;
        }

        .ubahpw-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 100px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .ubahpw-container h1 {
            font-size: 28px;
            text-align: center;
            margin-bottom: 30px;
        }

        .form-group label {
            font-size: 14px;
            color: #495057;
        }

        .btn-primary {
            width: 100%;
            background-color: #007bff;
            border: none;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .alert-danger {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="ubahpw-container">
        <h1>Update Username and Password</h1>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($error_message) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="new_username">New Username (optional):</label><br>
                <input type="text" class="form-control" id="new_username" name="new_username"
                    value="<?= htmlspecialchars($username_saatIni) ?>">
            </div>

            <div class="form-group">
                <label for="new_password">New Password:</label><br>
                <input type="password" class="form-control" id="new_password" name="new_password" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>