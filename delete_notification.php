<?php
require 'config/database.php';

// Check if the ID is passed in the request
if (isset($_POST['id'])) {
    $notificationId = $_POST['id'];

    // Delete the notification from the collection
    $result = $notificationsCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($notificationId)]);

    if ($result->getDeletedCount() > 0) {
        echo 'Notification deleted successfully';
    } else {
        echo 'Error deleting notification';
    }
} else {
    echo 'No notification ID provided';
}
?>
