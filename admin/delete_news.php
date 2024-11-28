<?php
require '../config/auth.php'; // Pastikan admin login
require '../config/database.php';

$id = new MongoDB\BSON\ObjectId($_GET['id']);

// Hapus berita dari database
$newsCollection->deleteOne(['_id' => $id]);

header('Location: manage_news.php');
exit;
?>
