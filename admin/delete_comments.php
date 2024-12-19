<?php
require '../config/auth.php'; 
require '../config/database.php';

$id = new MongoDB\BSON\ObjectId($_GET['id']);
$id_news =($_GET['id_news']);

$commentsCollection->deleteOne(['_id' => $id]);

header("Location: view_detail.php?id=" . urlencode($id_news));
exit;
?>
