<?php
include '../conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $delete_id = $_POST['delete_id'];

    $sql = "DELETE FROM bookings WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $delete_id);

    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Booking canceled successfully.</div>";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error canceling booking: " . $conn->error . "</div>";
    }
    $stmt->close();
}

$search_query = "";
$treatment_type = "";
if (isset($_GET['search'])) {
    $search_query = $_GET['search'];
}
if (isset($_GET['treatment_type'])) {
    $treatment_type = $_GET['treatment_type'];
}

$sql = "SELECT `id`, `booking_date`, `booked_by`, `user_id`, `address`, `phone`, `treatment_type`, `date_of_treatment`, `contract_price`, `technician`, `created_at`, `type_of_treatment`
        FROM `bookings`
        WHERE (`booked_by` LIKE ? OR `booking_date` LIKE ?)";

if (!empty($treatment_type)) {
    $sql .= " AND `treatment_type` = ?";
}

$stmt = $conn->prepare($sql);
$search_param = "%" . $search_query . "%";

if (!empty($treatment_type)) {
    $stmt->bind_param("sss", $search_param, $search_param, $treatment_type);
} else {
    $stmt->bind_param("ss", $search_param, $search_param);
}

$stmt->execute();
$result = $stmt->get_result();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* General modal settings */
.modal-content {
    border-radius: 8px;
    border: none;
}

/* Green modal header */
.modal-header {
    background-color: #2e7d32; /* Dark green */
    color: #fff;
}

.modal-header .btn-close {
    background-color: transparent;
    border: none;
    outline: none;
    opacity: 1;
}

.modal-header .btn-close:hover {
    background-color: rgba(255, 255, 255, 0.1); /* Subtle hover effect */
}

.modal-title {
    font-size: 1.5rem;
}

/* Green modal body */
.modal-body {
    background-color: #e8f5e9; /* Light green background */
    color: #1b5e20; /* Dark green text */
    padding: 20px;
}

/* Green labels and inputs */
.modal-body label {
    color: #1b5e20; /* Dark green */
    font-weight: bold;
}

.modal-body input {
    border: 1px solid #4caf50; /* Green border */
    border-radius: 5px;
    padding: 8px;
    width: 100%;
    box-shadow: none;
}

.modal-body input:focus {
    outline: none;
    border-color: #66bb6a; /* Slightly lighter green when focused */
    box-shadow: 0 0 5px #66bb6a; /* Focus shadow effect */
}

/* Modal footer */
.modal-footer {
    background-color: #2e7d32; /* Dark green */
    border-top: none;
}

/* Buttons in footer */
.btn-primary {
    background-color: #66bb6a; /* Green button */
    border-color: #4caf50;
    color: white;
}

.btn-primary:hover {
    background-color: #388e3c; /* Darker green on hover */
    border-color: #2e7d32;
}

.btn-secondary {
    background-color: #a5d6a7; /* Light green button */
    color: #1b5e20;
    border-color: #4caf50;
}

.btn-secondary:hover {
    background-color: #81c784; /* Slightly darker green */
    border-color: #66bb6a;
}

/* Additional button styles for modal close */
.btn-close {
    background-color: rgba(255, 255, 255, 0.8);
    border-radius: 50%;
}

.btn-close:hover {
    background-color: rgba(255, 255, 255, 1);
}
    </style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Booking Management</h2>

    <form class="form-inline mb-4" method="GET" action="" id="filterForm">
        <div class="input-group">
            <input type="text" class="form-control" name="search" placeholder="Search by name or date" value="<?php echo htmlspecialchars($search_query); ?>">
            <select class="form-select" name="treatment_type" onchange="document.getElementById('filterForm').submit();">
                <option value="">All Treatment Types</option>
                <option value="specific" <?php if ($treatment_type == 'specific') echo 'selected'; ?>>Specific</option>
                <option value="termite" <?php if ($treatment_type == 'termite') echo 'selected'; ?>>Termite</option>
            </select>
        </div>
    </form>

    <?php
    if ($result->num_rows > 0) {
        echo "<table class='table table-bordered table-hover'>
                <thead class='table-dark'>
                <tr>
                    <th>Booking Date</th>
                    <th>Booked By</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Treatment Type</th>
                    <th>Created At</th>
                    <th>Date of treatment</th>
                    <th>Price</th>
                    <th>technician</th>
                    <th>treatment</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["booking_date"] . "</td>
                    <td>" . $row["booked_by"] . "</td>
                    <td>" . $row["address"] . "</td>
                    <td>" . $row["phone"] . "</td>
                    <td>" . $row["treatment_type"] . "</td>
                    <td>" . $row["date_of_treatment"] . "</td>
                    <td>" . $row["contract_price"] . "</td>
                    <td>" . $row["technician"] . "</td>
                    <td>" . $row["type_of_treatment"] . "</td>
                    <td>" . $row["created_at"] . "</td>
                    <td>
                        <form method='post' action='' class='form-inline'>
                            <input type='hidden' name='delete_id' value='" . $row["id"] . "'>
                            <button type='submit' name='delete' class='btn btn-danger btn-sm'>DELETE</button>
                            <button type='button' class='btn btn-primary btn-sm' data-bs-toggle='modal' data-bs-target='#editModal' data-id='" . $row["id"] . "' data-treatment-type='" . $row["treatment_type"] . "'>EDIT</button>
                        </form>
                    </td>
                  </tr>";
        }
        echo "</tbody></table>";
    } else {
        echo "<div class='alert alert-info'>No bookings found.</div>";
    }
    $stmt->close();
    $conn->close();
    ?>
</div>

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="editModalLabel">Edit Booking</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="edit_booking.php" method="POST">
            <input type="hidden" name="id" id="bookingId">

            <label for="treatment_type">Treatment Type:</label>
            <input type="text" name="treatment_type" id="treatmentType" readonly />

           
            <div id="sharedFields" style="display: none;">
                <label for="date_of_treatment">Date of Treatment:</label>
                <input type="date" name="date_of_treatment" id="dateOfTreatment" />

                <label for="contract_price">Contract Price:</label>
                <input type="text" name="contract_price" id="contractPrice" />

                <label for="technician">Technician:</label>
                <input type="text" name="technician" id="technician" />
            </div>

            <div id="specificFields" style="display: none;">
                <label for="type_of_treatment">Type of Treatment:</label>
                <input type="text" name="type_of_treatment" id="typeOfTreatment" />
            </div>

            <input type="submit" name="submit" value="Update Booking" class="btn btn-primary" />
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var editModal = document.getElementById('editModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var bookingId = button.getAttribute('data-id');
        var treatmentType = button.getAttribute('data-treatment-type');

        var modal = this;
        modal.querySelector('#bookingId').value = bookingId;
        modal.querySelector('#treatmentType').value = treatmentType;

        var sharedFields = modal.querySelector('#sharedFields');
        var specificFields = modal.querySelector('#specificFields');

        if (treatmentType === 'termite') {
            sharedFields.style.display = 'block';
            specificFields.style.display = 'none';
        } else if (treatmentType === 'specific') {
            sharedFields.style.display = 'block';
            specificFields.style.display = 'block';
        } else {
            sharedFields.style.display = 'none';
            specificFields.style.display = 'none';
        }
    });
});
</script>

</body>
</html>
