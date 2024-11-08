<?php
session_start();
include 'conn.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Load PHPMailer

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash the password
    $otp = rand(100000, 999999); // Generate 6-digit OTP

    // Store user details with OTP (initially inactive)
    $sql = "INSERT INTO user_tbl (username, email, password, otp, is_verified) VALUES ('$username', '$email', '$hashedPassword', '$otp', 0)";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        // Send OTP email
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  // Specify your mail server
            $mail->SMTPAuth = true;
            $mail->Username = 'josephdechavez1515@gmail.com';  // Your SMTP username
            $mail->Password = 'kcct yhxn lvqo xpjq';         // Your SMTP password
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            

            // Recipients
            $mail->setFrom('no-reply@example.com', 'Your Website');
            $mail->addAddress($email); // Add recipient's email address

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Verify Your Email with OTP';
            $mail->Body    = "Dear $username,<br><br>Your OTP for verification is: <strong>$otp</strong>";

            $mail->send();
            echo "<script>alert('Registration successful. Check your email for OTP.');</script>";

            // Redirect to OTP verification page
            $_SESSION['email'] = $email; // Store email in session for OTP verification
            header("Location: otp_verification.php");
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script> alert('Registration Failed. Try Again');</script>";
    }
}
?>