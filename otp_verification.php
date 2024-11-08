<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_otp'])) {
    $otp_input = $_POST['otp'];
    $email = $_SESSION['email'];

    // Check if the OTP matches for the given email
    $sql = "SELECT * FROM user_tbl WHERE email='$email' AND otp='$otp_input'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // OTP is correct, mark user as verified
        $update_sql = "UPDATE user_tbl SET is_verified=1 WHERE email='$email'";
        mysqli_query($conn, $update_sql);

        // Unset the session variable and redirect to login
        unset($_SESSION['email']);
        echo "<script>alert('Your email has been verified. You can now log in.'); window.location.href = 'index.php';</script>";
    } else {
        echo "<script>alert('Invalid OTP. Please try again.');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>OTP Verification</title>

    <style>
        /* Global Styles */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        #container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        h1 {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
            letter-spacing: 1px;
        }

        label {
            font-size: 1rem;
            font-weight: 500;
            color: #34495e;
            margin-bottom: 10px;
            display: block;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            margin-bottom: 20px;
            border: 1px solid #bdc3c7;
            border-radius: 10px;
            font-size: 16px;
            background-color: #ecf0f1;
            transition: all 0.3s ease;
        }

        input[type="text"]:focus {
            border-color: #3498db;
            outline: none;
            background-color: #fff;
            box-shadow: 0 0 8px rgba(52, 152, 219, 0.3);
        }

        input[type="submit"] {
            background-color: #3498db;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #2980b9;
        }

        .error-message {
            color: #e74c3c;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .success-message {
            color: #27ae60;
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .info-message {
            color: #3498db;
            font-size: 0.9rem;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div id="container">
        <form method="post" action="otp_verification.php">
            <label for="otp">Enter OTP:</label><br>
            <input type="text" name="otp" placeholder="Enter the OTP sent to your email" required><br><br>

            <input type="submit" name="verify_otp" value="Verify"><br><br>
        </form>
    </div>
</body>
</html>
