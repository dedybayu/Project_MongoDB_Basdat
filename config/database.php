<?php
require 'vendor/autoload.php';
$client = new MongoDB\Client("mongodb://localhost:27017");
$db = $client->news_app;
$newsCollection = $db->news;
$notificationsCollection = $db->notifications;
?>
