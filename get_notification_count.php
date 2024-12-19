<?php
require 'config/database.php';

// Hitung notifikasi yang belum dibaca
$count = $notificationsCollection->count(['status' => 'unread']);
echo json_encode(['count' => $count]);
?>
