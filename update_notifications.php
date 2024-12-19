<?php
require 'config/database.php';

// Tandai semua notifikasi sebagai "read"
$notificationsCollection->updateMany(['status' => 'unread'], ['$set' => ['status' => 'read']]);

echo json_encode(['status' => 'success']);
?>
