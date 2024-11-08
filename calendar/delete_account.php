<?php
session_start();
include '../conn.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; 
    $query = "DELETE FROM `user_tbl` WHERE `id` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);

    if ($stmt->execute()) {
        session_destroy();
        echo "<script>alert('Account deleted successfully!'); window.location.href='../index.php';</script>";
    } else {
        echo "<script>alert('Error deleting account!'); window.location.href='edit_account.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
