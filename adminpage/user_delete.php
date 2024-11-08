<?php
include '../conn.php'; 

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $query = "DELETE FROM user_tbl WHERE id = $id";
    
    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Record deleted successfully'); window.location.href='user_conts.php';</script>";
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

$conn->close();
?>
