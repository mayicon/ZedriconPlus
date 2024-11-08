<?php
session_start(); 
include '../conn.php'; 
function loginUser($conn, $username, $password) {
    $query = "SELECT id, password FROM user_admin_tbl WHERE username = '$username' LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $username;
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
        echo "<script>alert('$result'); window.location.href='charts.php';</script>";
    } else {
        echo "<script>alert('$result'); window.location.href='index.php';</script>";
    }
}

$conn->close();
?>
