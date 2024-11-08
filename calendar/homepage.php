<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['username'])) {
    
    header("Location: ../index.php");
    exit();
}

?>

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
    background-color: #f4f6f5; /* Light neutral background with a hint of green */
}

.container-fluid {
    background-color: #e0f2f1; /* Very light green background */
    margin: 2px;
    padding: 10px;
    display: flex;
    
}

.serve {
    margin-top: 5%;
}

.txt {
    margin-top: 8%;
}

.txt h1 {
          font-family: 'Arial', sans-serif;
          font-size: 30px;
          font-weight: bold;
          color: #2c3e50; /* Dark blue-gray color */
          text-align: center;
          padding: 20px;
          background: #c0c0c0; /* Light gray background */
          box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
          margin: 20px;
        }
}

#services {
    padding: 50px 0;
    background-color: #f4f6f5; /* Light background to maintain consistency */
}

#services h2 {
    font-family: 'Arial', sans-serif;
    font-size: 2rem;
    font-weight: bold;
    color: #2e7d32; /* Dark green for headings */
    text-align: center;
    margin-bottom: 30px;
    padding: 10px 20px;
    border-radius: 8px;
    display: inline-block;
}

.service-list {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 30px; /* Space between cards */
}

.service-item {
    background-color: #ffffff; /* White background for clean look */
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Shadow for elegant card design */
    padding: 20px;
    width: 300px;
    text-align: center;
    transition: transform 0.3s, box-shadow 0.3s; /* Smooth transition on hover */
}

.service-item:hover {
    transform: translateY(-5px); /* Lift effect on hover */
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2); /* Deeper shadow on hover */
}

.service-item img {
    max-width: 100%;
    height: auto;
    border-radius: 8px; /* Rounded image corners */
}

.service-item h3 {
    margin-top: 15px;
    font-size: 1.6rem;
    color: #2e7d32; /* Dark green for service headings */
}

.service-item p {
    font-size: 1rem;
    color: #666666; /* Gray for body text */
    margin-bottom: 15px;
    text-align: left;
}

ul {
    text-align: left;
    padding-left: 20px;
}

.book {
    margin-top: 15%;
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
    margin-top: 50px;
    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow */
}

        .book{
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


    

<center>
    <div class="txt">
    <h1>We provide top-notch pest control services to keep your home and business safe and pest-free.</h1>
    </div>
</center>


<center>
<img src="../image/zed.jpg" class="img-fluid" alt="...">
</center>


        <!--services-->
        <center class="serve">
        <section id="services" class="services">
        <div class="container">
            <h2>Services</h2>
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
</body>
</html>