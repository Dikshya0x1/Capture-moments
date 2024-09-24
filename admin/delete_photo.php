<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}
include('../config.php');

if (isset($_GET['id'])) {
    $photo_id = escape($_GET['id']);
    
    // Delete the photo
    $sql = "DELETE FROM gallery WHERE id='$photo_id'";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: dashboard.php?deleted=1");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Photo ID not provided!";
}
?>
