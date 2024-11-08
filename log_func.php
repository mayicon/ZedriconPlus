<?php
session_start(); 
include 'conn.php'; 

function loginUser($conn, $username, $password) {
    $query = "SELECT id, password, acc_type FROM user_tbl WHERE username = '$username' LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
            $_SESSION['acc_type'] = $user['acc_type'];
            return "Login successful!";
        } else {
            return "Incorrect password!";
        }
    } else {
        return "Username not found!";
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $result = loginUser($conn, $username, $password);
    
    if ($result === "Login successful!") {
        if ($_SESSION['acc_type'] === 'admin') {
            echo "<script>alert('$result'); window.location.href='adminpage/charts.php';</script>";
        } else {
            echo "<script>alert('$result'); window.location.href='calendar/homepage.php';</script>";
        }
    } else {
        echo "<script>alert('$result'); window.location.href='index.php';</script>";
    }
}

$conn->close();
?>
