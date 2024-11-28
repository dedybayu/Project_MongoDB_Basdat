<?php
require 'database.php'; // Menggunakan koneksi dari database.php

// Pilih koleksi users
$usersCollection = $db->users;

// Data pengguna baru
$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT); // Ganti "admin123" dengan password pilihan Anda

try {
    // Cek apakah username sudah ada
    $existingUser = $usersCollection->findOne(['username' => $username]);

    if ($existingUser) {
        echo "Username '$username' sudah ada di database.";
    } else {
        // Tambahkan pengguna baru
        $usersCollection->insertOne([
            'username' => $username,
            'password' => $password,
            'created_at' => new MongoDB\BSON\UTCDateTime()
        ]);

        echo "Pengguna '$username' berhasil dibuat!";
    }
} catch (Exception $e) {
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>
