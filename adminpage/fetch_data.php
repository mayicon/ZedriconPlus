<?php
include '../conn.php';

$period = $_POST['period'];
$query = "";

switch ($period) {
    case 'weekly':
        $query = "SELECT WEEK(booking_date) AS week, COUNT(*) AS count FROM bookings GROUP BY WEEK(booking_date)";
        break;
    case 'monthly':
        $query = "SELECT MONTH(booking_date) AS month, COUNT(*) AS count FROM bookings GROUP BY MONTH(booking_date)";
        break;
    case 'yearly':
        $query = "SELECT YEAR(booking_date) AS year, COUNT(*) AS count FROM bookings GROUP BY YEAR(booking_date)";
        break;
    default:
        echo json_encode([]);
        exit;
}

$result = $conn->query($query);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = [
        'category' => $period === 'weekly' ? 'Week ' . $row['week'] : ($period === 'monthly' ? 'Month ' . $row['month'] : 'Year ' . $row['year']),
        'count' => (int)$row['count']
    ];
}

echo json_encode($data);

$conn->close();
?>
