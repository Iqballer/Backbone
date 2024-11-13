<?php
// delete_lagu.php
include '../koneksi.php';
session_start();

// Check if the user is an admin
if ($_SESSION['role'] != 'admin') {
    header('Location: ../index.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM musik WHERE id_musik = $id";
    if (mysqli_query($conn, $query)) {
        header('Location: manage_lagu.php');
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header('Location: manage_lagu.php');
}
?>