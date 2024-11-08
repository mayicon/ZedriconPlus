<?php
include '../conn.php';

session_start(); 
// Fetch unread notifications
$fetchNotificationsQuery = "SELECT * FROM notifications WHERE is_read = 0 ORDER BY created_at DESC";
$result = $conn->query($fetchNotificationsQuery);
$unreadCount = $result->num_rows;


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

$sql = "SELECT `id`, `booking_date`, `booked_by`, `user_id`, `address`, `phone`, `remarks`, `treatment_type`, `date_of_treatment`, `contract_price`, `technician`, `created_at`, `type_of_treatment`
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Document</title>
    <style>

@import url("https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap");:root{--header-height: 3rem;--nav-width: 68px;--first-color: #4CAF50;--first-color-light: #000000;--white-color: #F7F6FB;--body-font: 'Nunito', sans-serif;--normal-font-size: 1rem;--z-fixed: 100}*,::before,::after{box-sizing: border-box}body{position: relative;margin: var(--header-height) 0 0 0;padding: 0 1rem;font-family: var(--body-font);font-size: var(--normal-font-size);transition: .5s}a{text-decoration: none}.header{width: 100%;height: var(--header-height);position: fixed;top: 0;left: 0;display: flex;align-items: center;justify-content: space-between;padding: 0 1rem;background-color: var(--white-color);z-index: var(--z-fixed);transition: .5s}.header_toggle{color: var(--first-color);font-size: 1.5rem;cursor: pointer}.header_img{width: 35px;height: 35px;display: flex;justify-content: center;border-radius: 50%;overflow: hidden}.header_img img{width: 40px}.l-navbar{position: fixed;top: 0;left: -30%;width: var(--nav-width);height: 100vh;background-color: var(--first-color);padding: .5rem 1rem 0 0;transition: .5s;z-index: var(--z-fixed)}.nav{height: 100%;display: flex;flex-direction: column;justify-content: space-between;overflow: hidden}.nav_logo, .nav_link{display: grid;grid-template-columns: max-content max-content;align-items: center;column-gap: 1rem;padding: .5rem 0 .5rem 1.5rem}.nav_logo{margin-bottom: 2rem}.nav_logo-icon{font-size: 1.25rem;color: var(--white-color)}.nav_logo-name{color: var(--white-color);font-weight: 700}.nav_link{position: relative;color: var(--first-color-light);margin-bottom: 1.5rem;transition: .3s}.nav_link:hover{color: var(--white-color)}.nav_icon{font-size: 1.25rem}.show{left: 0}.body-pd{padding-left: calc(var(--nav-width) + 1rem)}.active{color: var(--white-color)}.active::before{content: '';position: absolute;left: 0;width: 2px;height: 32px;background-color: var(--white-color)}.height-100{height:100vh}@media screen and (min-width: 768px){body{margin: calc(var(--header-height) + 1rem) 0 0 0;padding-left: calc(var(--nav-width) + 2rem)}.header{height: calc(var(--header-height) + 1rem);padding: 0 2rem 0 calc(var(--nav-width) + 2rem)}.header_img{width: 40px;height: 40px}.header_img img{width: 45px}.l-navbar{left: 0;padding: 1rem 1rem 0 0}.show{width: calc(var(--nav-width) + 156px)}.body-pd{padding-left: calc(var(--nav-width) + 188px)}}

<!-- Custom Green Palette -->
    
        body {
            background-color: #f1f8f4;
        }

        .btn-primary {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-primary:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .table-dark {
            background-color: #28a745;
            color: #fff;
        }

        .table-hover tbody tr:hover {
            background-color: #e3f2e1;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }

        .alert-info {
            background-color: #cce5ff;
            color: #004085;
        }

        .modal-header, .btn-close {
            background-color: #28a745;
            color: #fff;
        }

        .form-control, .form-select {
            border-color: #28a745;
        }

        .btn-primary.w-100 {
            background-color: #28a745;
        }
    </style>

</style>
</head>
<body>
<body id="body-pd">
    <header class="header" id="header">
        <div class="header_toggle"> <i class='bx bx-menu' id="header-toggle"></i> </div>
    </header>
    <div class="l-navbar" id="nav-bar">
        <nav class="nav">
            <div> 
                <a href="#" class="nav_logo"> 
                    <i class='bx bx-layer nav_logo-icon'></i>
                     <span class="nav_logo-name">ZedriconPlus</span> 
                    </a>
                    <div class="nav_list">
                     <a href="charts.php" class="nav_link">
                        <i class='bx bx-grid-alt nav_icon'></i>
                          <span class="nav_name">Dashboard</span>
                         </a> 
                         <a href="user_conts.php" class="nav_link">
                             <i class='bx bx-user nav_icon'></i>
                              <span class="nav_name">Users</span>
                             </a> 
                                  <a href="scheds.php" class="nav_link active">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
  <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0"/>
  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>
</svg>
                                     <span class="nav_name">Booking</span> 
                                    </a> 
                                    
                                    <a href="add.php" class="nav_link">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar2-plus" viewBox="0 0 16 16">
  <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M2 2a1 1 0 0 0-1 1v11a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1z"/>
  <path d="M2.5 4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5H3a.5.5 0 0 1-.5-.5zM8 8a.5.5 0 0 1 .5.5V10H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V11H6a.5.5 0 0 1 0-1h1.5V8.5A.5.5 0 0 1 8 8"/>
</svg>
                                     <span class="nav_name">Add</span> 
                                    </a> 
                                    <a href="notif.php" class="nav_link">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bell" viewBox="0 0 16 16">
            <path d="M8 16a2 2 0 0 0 2-2H6a2 2 0 0 0 2 2M8 1.918l-.797.161A4 4 0 0 0 4 6c0 .628-.134 2.197-.459 3.742-.16.767-.376 1.566-.663 2.258h10.244c-.287-.692-.502-1.49-.663-2.258C12.134 8.197 12 6.628 12 6a4 4 0 0 0-3.203-3.92zM14.22 12c.223.447.481.801.78 1H1c.299-.199.557-.553.78-1C2.68 10.2 3 6.88 3 6c0-2.42 1.72-4.44 4.005-4.901a1 1 0 1 1 1.99 0A5 5 0 0 1 13 6c0 .88.32 4.2 1.22 6"/>
        </svg>
        <span class="nav_name">Notification</span>
        <?php if($unreadCount > 0): ?>
            <span class="badge bg-danger"><?= $unreadCount ?></span>
        <?php endif; ?>
    </a>
    </div>
        
        </div> 
        <div>
        <a href="settings.php?id=<?php echo $_SESSION['user_id']; ?>" class="nav_link"> 
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
<path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0"/>
<path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z"/>
</svg>
       <span class="nav_name">Settings</span> 

        <a href="logout.php" class="nav_link"> 
       <i class='bx bx-log-out nav_icon'></i>
       <span class="nav_name">Sign Out</span> 
       </a>
</nav>
</div>
    <!--Container Main start-->
    <div class="height-100 bg-light">

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
                    <th>Remarks</th>
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
                    <td>" . $row["remarks"] . "</td>
                    <td>" . $row["treatment_type"] . "</td>
                    <td>" . $row["created_at"] . "</td>
                    <td>" . $row["date_of_treatment"] . "</td>
                    <td>" . $row["contract_price"] . "</td>
                    <td>" . $row["technician"] . "</td>
                    <td>" . $row["type_of_treatment"] . "</td>
                  
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





    document.addEventListener("DOMContentLoaded", function(event) {
   
   const showNavbar = (toggleId, navId, bodyId, headerId) =>{
   const toggle = document.getElementById(toggleId),
   nav = document.getElementById(navId),
   bodypd = document.getElementById(bodyId),
   headerpd = document.getElementById(headerId)
   
   // Validate that all variables exist
   if(toggle && nav && bodypd && headerpd){
   toggle.addEventListener('click', ()=>{
   // show navbar
   nav.classList.toggle('show')
   // change icon
   toggle.classList.toggle('bx-x')
   // add padding to body
   bodypd.classList.toggle('body-pd')
   // add padding to header
   headerpd.classList.toggle('body-pd')
   })
   }
   }
   
   showNavbar('header-toggle','nav-bar','body-pd','header')
   
   /*===== LINK ACTIVE =====*/
   const linkColor = document.querySelectorAll('.nav_link')
   
   function colorLink(){
   if(linkColor){
   linkColor.forEach(l=> l.classList.remove('active'))
   this.classList.add('active')
   }
   }
   linkColor.forEach(l=> l.addEventListener('click', colorLink))
   
    // Your code to run since DOM is loaded and ready
   });
</script>


</html>