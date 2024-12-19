<?php
require 'config/database.php';

// Ambil notifikasi yang belum dibaca
$notifications = $notificationsCollection->find(['status' => 'unread'], ['sort' => ['created_at' => -1]]);
$notificationData = [];

// Cek apakah ada notifikasi
foreach ($notifications as $notification) {
    $notificationData[] = [
        'message' => $notification['message'],
        'created_at' => $notification['created_at']->toDateTime()->format('d M Y, H:i')
    ];
}

// Mengembalikan data notifikasi dalam format JSON
echo json_encode($notificationData);
?>
