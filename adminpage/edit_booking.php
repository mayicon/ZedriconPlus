<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $treatment_type = $_POST['treatment_type'];

    // Initialize the update SQL and prepare statement variable
    $update_sql = "";
    $stmt = null;

    // If treatment type is 'termite', update the date_of_treatment, contract_price, and technician fields
    if ($treatment_type === 'termite') {
        $date_of_treatment = $_POST['date_of_treatment'];
        $contract_price = $_POST['contract_price'];
        $technician = $_POST['technician'];

        $update_sql = "UPDATE bookings SET date_of_treatment = ?, contract_price = ?, technician = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("sssi", $date_of_treatment, $contract_price, $technician, $id);
    } 
    // If treatment type is 'specific', update type_of_treatment, date_of_treatment, contract_price, and technician fields
    elseif ($treatment_type === 'specific') {
        $type_of_treatment = $_POST['type_of_treatment'];
        $date_of_treatment = $_POST['date_of_treatment'];
        $contract_price = $_POST['contract_price'];
        $technician = $_POST['technician'];

        $update_sql = "UPDATE bookings SET type_of_treatment = ?, date_of_treatment = ?, contract_price = ?, technician = ? WHERE id = ?";
        $stmt = $conn->prepare($update_sql);
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("ssssi", $type_of_treatment, $date_of_treatment, $contract_price, $technician, $id);
    }

    // Execute the query if the statement was prepared successfully
    if ($stmt && $stmt->execute()) {
        header("Location: scheds.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close statement and connection
    if ($stmt) {
        $stmt->close();
    }
    $conn->close();
}
?>
