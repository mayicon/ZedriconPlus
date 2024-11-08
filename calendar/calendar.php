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
echo "<a href='?month=" . ($month == 1 ? 12 : $month - 1) . "&year=" . ($month == 1 ? $year - 1 : $year) . "'>Previous Month</a>";
echo " | ";
echo "<a href='?month=" . ($month == 12 ? 1 : $month + 1) . "&year=" . ($month == 12 ? $year + 1 : $year) . "'>Next Month</a>";
echo "</div>";

$conn->close();
?>
