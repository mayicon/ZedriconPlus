<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>ZedriconPlus</title>
    <style>
        body {
            width: 100%;
            height: 100%;
            font-family: "Roboto", sans-serif;
            background-color: #2979FF;
        }
        .serve {
            margin-top: 5%;
        }
        .txt {
            margin-top: 12%;
        }
        #services {
            padding: 40px 0;
            background-color: #fff;
        }
        #services h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 2rem;
            color: #333;
        }
        .service-list {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .service-item {
            background-color: #fafafa;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin: 15px;
            padding: 20px;
            width: 300px;
            text-align: center;
        }
        .service-item img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
        .service-item h3 {
            margin-top: 15px;
            font-size: 1.5rem;
            color: #333;
        }
        .service-item p {
            font-size: 1rem;
            color: #666;
            margin-bottom: 15px;
            text-align: left;
        }
        .book {
            margin-top: 15%;
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
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#services">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#book">Book Now</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
           Account
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#signupModal">Signup</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>


<center>
    <div class="txt">
    <h1>We provide top-notch pest control services to keep your home and business safe and pest-free.</h1>
    </div>
</center>


<center>
<img src="../image/zed.jpg" class="img-fluid" alt="...">
</center>

<section id="book" class="book">
<?php

$month = date('m');
$year = date('Y');

if (isset($_GET['month'])) {
    $month = $_GET['month'];
}
if (isset($_GET['year'])) {
    $year = $_GET['year'];
}


$first_day_of_month = mktime(0, 0, 0, $month, 1, $year);
$days_in_month = date('t', $first_day_of_month); 
$day_of_week = date('w', $first_day_of_month);    
$month_name = date('F', $first_day_of_month);   


$conn = new mysqli('localhost', 'root', '', 'booking_system');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "<style>
    body {
        font-family: Arial, sans-serif;
    }
    h2 {
        text-align: center;
    }
    table {
        width: 100%;
        max-width: 600px;
        margin: 20px auto;
        border-collapse: collapse;
    }
    th {
        background-color: #f2f2f2;
        padding: 10px;
    }
    td {
        width: 14.28%;
        height: 80px;
        text-align: center;
        vertical-align: middle;
        border: 1px solid #ddd;
        position: relative;
    }
    td a {
        display: block;
        width: 100%;
        height: 100%;
        text-decoration: none;
        color: black;
        transition: background-color 0.3s, color 0.3s;
    }
    td a:hover {
        background-color: #e0e0e0;
        color: #000;
    }
    td[style] {
        background-color: #ffcccc !important;
        color: black;
    }
    a {
        text-decoration: none;
        color: #007bff;
    }
    a:hover {
        text-decoration: underline;
    }
    .nav-links {
        text-align: center;
        margin: 20px 0;
    }
</style>";

echo "<h2>$month_name $year</h2>";

echo "<table>";
echo "<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr><tr>";


for ($i = 0; $i < $day_of_week; $i++) {
    echo "<td></td>";
}

for ($day = 1; $day <= $days_in_month; $day++) {
    if (($day + $day_of_week - 1) % 7 == 0) {
        echo "</tr><tr>";
    }
    $date = sprintf('%04d-%02d-%02d', $year, $month, $day);
    $stmt = $conn->prepare("SELECT id FROM bookings WHERE booking_date = ?");
    $stmt->bind_param('s', $date);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        echo "<td style='background-color: #ffcccc;'>$day</td>";
    } else {
        echo "<td><a href='book.php?date=$date'>$day</a></td>";
    }

    $stmt->close();
}

while (($day + $day_of_week - 1) % 7 != 0) {
    echo "<td></td>";
    $day++;
}

echo "</tr></table>";

echo "<div class='nav-links'>";
echo "<a href='?month=" . ($month == 1 ? 12 : $month - 1) . "&year=" . ($month == 1 ? $year - 1 : $year) . "' style='color: black;'>Previous Month</a>";
echo " | ";
echo "<a href='?month=" . ($month == 12 ? 1 : $month + 1) . "&year=" . ($month == 12 ? $year + 1 : $year) . "' style='color: black;'>Next Month</a>";
echo "</div>";

$conn->close();
?>
</section>


        <!--services-->
        <center class="serve">
        <section id="services" class="services">
        <div class="container">
            <h2>Our Services</h2>
            <div class="service-list">
                <div class="service-item">
                    <img src="../image/image1.jpg" alt="General Treatment Image">
                    <h3>General Treatment</h3>
                    <p>General treatment for pest control refers to a broad, preventive approach to managing and reducing pest populations in a specific area, such as a home, garden, or commercial property.</p>
                    <p><strong>Key Features:</strong></p>
                    <ul>
                        <li>Inspection and Identification</li>
                        <li>Chemical Treatments</li>
                        <li>Physical Barriers and Exclusion</li>
                        <li>Environmental Management</li>
                        <li>Monitoring and Follow-up</li>
                    </ul>
                </div>
                <div class="service-item">
                    <img src="../image/image1.jpg" alt="Termite Treatment Image">
                    <h3>Termite Treatment</h3>
                    <p>Termite treatment refers to the various methods used to eliminate and prevent termite infestations in structures like homes and buildings.</p>
                    <p><strong>Key Features:</strong></p>
                    <ul>
                        <li>Liquid Termiticides</li>
                        <li>Baiting Systems</li>
                        <li>Wood Treatments</li>
                        <li>Fumigation</li>
                        <li>Heat Treatment</li>
                        <li>Physical Barriers</li>
                        <li>Integrated Pest Management</li>
                        <li>Regular Monitoring</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container">
            <p>&copy; 2024 ZedriconPlus. All rights reserved.</p>

        </div>
    </footer>
</center>

























<!-- Modal login-->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="loginModalLabel">Login</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="log_func.php" method="POST">
      <input type="text" id="username" placeholder="Username" name="username" required>
            <input type="password" id="password" placeholder="Password" name="password" required>
                 <button>Login</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal signup-->
<div class="modal fade" id="signupModal" tabindex="-1" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="signupModalLabel">Sign Up</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <form action="reg_func.php" method="POST">
      <input type="text" id="username" placeholder="Username" name="username" required>
          <input type="password" id="password" placeholder="Password" name="password"required>
                 <button>Sign Up</button>
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>


</body>
</html>
