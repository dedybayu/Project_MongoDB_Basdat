<?php
require '../config/auth.php'; 
require '../config/database.php';

$id = new MongoDB\BSON\ObjectId($_GET['id']);

$newsCollection->deleteOne(['_id' => $id]);

header('Location: manage_news.php');
exit;
?>
