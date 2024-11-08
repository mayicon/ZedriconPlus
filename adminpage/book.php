<?php
session_start();

if (!isset($_GET['date'])) {
    die("No date provided.");
}

$date = $_GET['date'];

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id']; // Get the user_id from the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booked_by = $_POST['booked_by'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $remarks = $_POST['remarks'];
    $treatment_type = $_POST['treatment_type'];

    $conn = new mysqli('localhost', 'root', '', 'booking_system');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Insert into database with user_id
    $stmt = $conn->prepare("INSERT INTO bookings (booking_date, booked_by, user_id, address, phone, remarks, treatment_type) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param('ssissss', $date, $booked_by, $user_id, $address, $phone, $remarks, $treatment_type);
    
    if ($stmt->execute()) {
        $message = "Booking confirmed for $date.";

        // Insert a notification for the admin
        $notificationMessage = "A new booking has been made by user_id: $user_id";
        $insertNotificationQuery = "INSERT INTO notifications (message) VALUES (?)";
        $stmt = $conn->prepare($insertNotificationQuery);
        $stmt->bind_param("s", $notificationMessage);
        $stmt->execute();

    } else {
        $message = "Failed to book the date.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Date</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f0f4f8;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #333;
        }

        input[type="text"],
        input[type="tel"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #4caf50;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 20px;
            font-size: 16px;
            color: #555;
        }

        .back-link {
            display: block;
            margin-top: 20px;
            text-decoration: none;
            color: #4caf50;
            font-size: 16px;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            input[type="submit"] {
                padding: 10px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Book Date: <?php echo htmlspecialchars($date); ?></h2>

    <form method="POST">
        <input type="text" name="booked_by" placeholder="Enter who is booking" required>
        <input type="text" name="address" placeholder="Enter your address" required>
        <input type="tel" name="phone" placeholder="Enter your phone number" required>
        <textarea name="remarks" placeholder="Enter any remarks" rows="4"></textarea>
        
        <select name="treatment_type" required>
            <option value="termite">General Treatment</option>
            <option value="specific">Normal Treatment</option>
        </select>
        
        <input type="submit" value="Book">
    </form>

    <a href="charts.php" class="back-link">Back</a>

    <?php if (isset($message)): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
</div>

</body>
</html>