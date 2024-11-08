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
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #e8f5e9;
        margin: 0;
        padding: 20;
        color: #333;
        
    }
    h2 {
        text-align: center;
        color: #2c6b2f;
        margin: 20px 0;
    }
    table {
        width: 90%;
        max-width: 700px;
        margin: 0 auto;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    th {
        background-color: #388e3c;
        color: white;
        padding: 12px 15px;
        font-size: 14px;
        text-transform: uppercase;
    }
    td {
        width: 14.28%;
        height: 100px;
        text-align: center;
        vertical-align: middle;
        border: 1px solid #c8e6c9;
        position: relative;
        font-size: 16px;
    }
    td a {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-decoration: none;
        color: #2c6b2f;
        transition: background-color 0.3s, color 0.3s;
        font-weight: bold;
    }
    td a:hover {
        background-color: #2c6b2f;
        color: white;
    }
    td[style] {
        background-color: #a5d6a7 !important;
        color: black;
        font-weight: bold;
    }
    .nav-links {
        text-align: center;
        margin: 20px 0;
    }
    .nav-links a {
        text-decoration: none;
        color: #388e3c;
        font-size: 16px;
        padding: 10px 20px;
        border: 2px solid #388e3c;
        border-radius: 5px;
        transition: background-color 0.3s, color 0.3s;
        margin: 0 10px;
    }
    .nav-links a:hover {
        background-color: #388e3c;
        color: white;
    }
    @media (max-width: 600px) {
        table {
            width: 100%;
        }
        td {
            height: 80px;
            font-size: 14px;
        }
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
        echo "<td style='background-color: #a5d6a7;'>$day</td>";
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
echo "<a href='?month=" . ($month == 1 ? 12 : $month - 1) . "&year=" . ($month == 1 ? $year - 1 : $year) . "'>Previous Month</a>";
echo "<a href='?month=" . ($month == 12 ? 1 : $month + 1) . "&year=" . ($month == 12 ? $year + 1 : $year) . "'>Next Month</a>";
echo "</div>";

$conn->close();
?>

</section>
