<?php
require '../../config/database.php'; // Menggunakan koneksi dari database.php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    if ($username == $_SESSION['admin_username']) {
        $admin = $db->users->findOne(['username' => $username]);

        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['change_password'] = true;
            $_SESSION['change_password_username'] = $username;
            header('Location: change_password.php');
            exit;
        } else {
            $error = "Username atau password salah.";
        }
    } else {
        $error = "Username atau password salah.";
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

        .login-container {
            max-width: 800px;
            margin: 50px auto;
            background: white;
            padding: 100px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .login-container h1 {
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
<div class="login-container">
    <h1>Login Lagi untuk Ubah Password</h1>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form action="" method="post">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
