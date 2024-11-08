<?php
include '../conn.php';

function registerUser($conn, $username, $password, $acc_type) {
    $query = "SELECT id FROM user_tbl WHERE username = '$username' LIMIT 1";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        return "Username already exists!";
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $query = "INSERT INTO user_tbl (username, password, acc_type) VALUES ('$username', '$hashedPassword', '$acc_type')";
    
    if ($conn->query($query) === TRUE) {
        return "User registered successfully!";
    } else {
        return "Error: " . $conn->error;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $acc_type = $conn->real_escape_string($_POST['acc_type']);
    $result = registerUser($conn, $username, $password, $acc_type);

    if ($result === "User registered successfully!") {
        echo "<script>alert('$result'); window.location.href='settings.php';</script>";
    } else {
        echo "<script>alert('$result'); window.location.href='settings.php';</script>";
    }
}

$conn->close();
?>
