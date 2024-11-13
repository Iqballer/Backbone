<?php
// delete_user.php
require '../koneksi.php';
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM user WHERE id_user = $id";
    if (mysqli_query($conn, $query)) {
        header('Location: manage_user.php');
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header('Location: manage_user.php');
}
?>