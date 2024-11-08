<?php
session_start();
include '../conn.php'; 
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id']; 
    $username = $conn->real_escape_string($_POST['username']);
    $new_password = $conn->real_escape_string($_POST['new_password']);

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    
    $query = "UPDATE `user_admin_tbl` SET `username` = ?, `password` = ? WHERE `id` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $username, $hashed_password, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Account updated successfully!'); window.location.href='homepage.php';</script>";
    } else {
        echo "<script>alert('Error updating account!'); window.location.href='edit_account.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
