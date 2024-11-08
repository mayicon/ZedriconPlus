<?php
session_start(); 
include '../conn.php'; 
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}


$user_id = $_SESSION['user_id'];

$query = "SELECT `id`, `username` FROM `user_tbl` WHERE `id` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <title>Edit Account</title>
        <style>
           body {
    width: 100%;
    height: 100%;
    font-family: "Roboto", sans-serif;
    background-color: #f4f6f5; /* Light neutral background with a hint of green */
}

.container-fluid {
    background-color: #e0f2f1; /* Very light green background */
    margin: 2px;
    padding: 10px;
}
body {
    font-family: Arial, sans-serif;
    background-color: #e0f2e9; /* Light green background */
    margin: 0;
    padding: 20px;
}

.container1 {
    margin: 5% auto; /* Center the container */
    max-width: 600px;
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 0 15px rgba(0, 128, 0, 0.2); /* Green shadow effect */
    border: 2px solid #88d498; /* Soft green border */
}

h1 {
    font-size: 26px;
    margin-bottom: 25px;
    color: #388e3c; /* Green text for header */
    text-align: center; /* Center-align header */
}

form {
    margin-bottom: 25px;
}

label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
    color: #388e3c; /* Green text for labels */
}

input[type="text"],
input[type="password"] {
    width: 100%;
    padding: 12px;
    border: 1px solid #88d498; /* Green border */
    border-radius: 6px;
    margin-bottom: 15px;
    box-sizing: border-box;
    font-size: 16px;
    background-color: #f0fff4; /* Light greenish input background */
}

button {
    background-color: #388e3c; /* Dark green button */
    color: #fff;
    border: none;
    padding: 12px 25px;
    border-radius: 6px;
    cursor: pointer;
    font-size: 16px;
    display: block;
    width: 100%;
    margin-top: 15px;
    text-align: center;
    transition: background-color 0.3s ease; /* Smooth hover transition */
}

button:hover {
    background-color: #2e7d32; /* Darker green on hover */
}

.delete-button {
    background-color: #d32f2f; /* Red for delete */
    margin-top: 20px;
}

.delete-button:hover {
    background-color: #b71c1c; /* Darker red on hover */
}

            /* Minimalist Navbar */
.navbar {
    background-color: #2e7d32; /* Dark green for navbar */
    padding: 10px 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

.navbar-brand {
    font-size: 1.5rem;
    color: #000000; /* White text for contrast */
}

.navbar-nav .nav-item .nav-link {
    font-size: 1rem;
    color: #000000; /* White links */
    margin-right: 15px;
    transition: background-color 0.3s;
}

.navbar-nav .nav-item .nav-link:hover {
    background-color: #4caf50; /* Lighter green on hover */
    border-radius: 5px;
}

.navbar-toggler-icon {
    filter: invert(100%); /* White toggle icon */
}

/* Footer */
footer {
    background-color: #2e7d32; /* Dark green footer */
    padding: 20px;
    color: #ffffff;
    text-align: center;
    margin-top: 270px;
    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}
        </style>
    </head>
    <body>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">ZedriconPlus</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="homepage.php#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="homepage.php#services">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="AboutUs.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="http://localhost/azrael/calendar/book1.php">Book Now</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Account
          </a>
          <ul class="dropdown-menu">
          <li><a class="dropdown-item" href="settings.php?id=<?php echo $_SESSION['user_id']; ?>">Settings</a></li>
        <!--<li><a class="dropdown-item" href="booked.php?user_id=<?php echo $_SESSION['user_id']; ?>">My Bookings</a></li>-->
            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

    <div class="container1">
        <h1>Edit Your Account</h1>

        <form action="update_account.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <label for="username">Username:</label>
            <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required><br>

            <label for="new_password">New Password:</label>
            <input type="password" name="new_password" placeholder="Enter new password" required><br>

            <button type="submit">Update</button>
        </form>

        <!-- Delete Account Form -->
        <form action="delete_account.php" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($user['id']); ?>">
            <button type="submit" class="delete-button" onclick="return confirm('Are you sure you want to delete your account?');">Delete Account</button>
        </form>
       
    </div>
    <footer>
        <div class="container">
            <p>&copy; 2024 ZedriconPlus. All rights reserved.</p>
        </div>
    </footer>
    </body>
    </html>
    <?php
} else {
    echo "User not found.";
}

$stmt->close();
$conn->close();
?>
