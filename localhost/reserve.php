<?php
require_once 'connection.php';
session_start();

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Initialize variables to hold form data
$userId = $_SESSION['user_id'];
$availableTimes = [];
$selectedDate = isset($_POST['date']) ? $_POST['date'] : '';
$selectedSection = isset($_POST['section']) ? $_POST['section'] : '';
$isAdmin = ($_SESSION['username'] === 'admin'); 
// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'make_reservation') {
    $section = $_POST['section'];
    $Date = $_POST['date'];
    $Time1 = $_POST['time'];
    $Time2 = date('H:i', strtotime($Time1 . ' +1 hour'));
    $Persons = $_POST['persons'];
    $payment = $_POST['payment'];
    $status = 'active';



    // Check if the selected time slot for the chosen section is available
    $checkQuery = "SELECT * FROM reservations WHERE dater = '$Date' AND section = '$section' AND status= 'active' AND((time1 <= '$Time1' AND time2 >= '$Time1') OR (time1 <= '$Time2' AND time2 >= '$Time2'))";
    $checkResult = $conn->query($checkQuery);

 
    if ($checkResult && $checkResult->num_rows > 0) {
        echo "Selected time slot for $section is already reserved. Please choose another time.";
    } else {
        // Check if user already has an active reservation
        $activeQuery = "SELECT * FROM reservations WHERE user_id = $userId AND status = 'active'";
        $activeResult = $conn->query($activeQuery);

        if ($activeResult && $activeResult->num_rows > 0) {
            echo "You can only have one active reservation at a time.";
        } else {
    // Construct the SQL query directly
    $insertQuery = "INSERT INTO reservations (user_id, section, dater, time1, time2, persons, payment, status) 
                    VALUES ('$userId', '$section', '$Date', '$Time1', '$Time2', $Persons, '$payment', '$status')";

    // Execute the query
    if ($conn->query($insertQuery) === TRUE) {
        echo "Reservation successful.";
    } else {
        echo "Error: " . $conn->error;
    }
}
    }
}

$sql = "SELECT * FROM timer";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$openTime = $row['openTime'];
$closeTime = $row['closeTime'];
//echo $openTime,"tst",$closeTime;

// Fetch available times if date and section are selected
if ($selectedDate && $selectedSection) {
    
    // Query to fetch existing reservations for the selected date and section
    $query = "SELECT time1, time2 FROM reservations WHERE dater = '$selectedDate' AND section = '$selectedSection' AND status = 'active'";
    $result = $conn->query($query);
    $reservedTimes = [];
    
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $startTime = strtotime($row['time1']);
            $endTime = strtotime($row['time2']);

            // Generate reserved times between start and end time
            while ($startTime < $endTime) {
                $reservedTimes[] = date('H:i', $startTime);
                $startTime = strtotime('+1 hour', $startTime);
            }
        }
    }

    // Generate available times based on open hours and existing reservations
    $currentTime = strtotime($openTime);
    $endTime = strtotime($closeTime);
    
    while ($currentTime < $endTime) {
        $timeSlot = date('H:i', $currentTime);
        if (!in_array($timeSlot, $reservedTimes)) {
            $availableTimes[] = $timeSlot;
        }
        $currentTime = strtotime('+1 hour', $currentTime);
    }
}

//update time by admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['Ntime'])) {
    $newOpen = $_POST['timeO'];
    $newClose = $_POST['timeC'];
    $sql = "UPDATE timer SET openTime = '$newOpen', closeTime = '$newClose'";
    $conn->query($sql);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</head>
<body class="body" data-bs-theme="dark">
<div>
<nav class="navbar navbar-expand-lg bg-body-tertiary font">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">ModernMUS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="reserve.php">Tour</a></li>
                    <li class="nav-item"><a class="nav-link" href="feedbacks.php">Feedbacks</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                                <?php if ($_SESSION['username'] == 'admin'): ?>
                                    <li><a class="nav-link" href="admin.php">ADMIN</a></li>
                                <?php endif; ?>
                                <li><a class="nav-link" href="logout.php">Logout</a></li>
                                <?php else: ?>

                                    <li><a class="nav-link" href="signup.php">Sign up</a></li>
                                    
                                <?php endif; ?>
                            </ul>
                        </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
    <div class="container">
        <h1>MODERN-Museum</h1>
        <h2>Make a Reservation For a Guided Tour</h2>
       
        <!-- Reservation Form -->
        <form id="reservationForm" method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" class="mb-4 container form-container">
            <div class="mb-3">
                <label for="section" class="form-label">Select Section</label>
                <select class="form-select" id="section" name="section" required>
                    <option value="">Select an option</option>
                    <option value="Ancient Egypt" <?php echo $selectedSection == 'Ancient Egypt' ? 'selected' : ''; ?>>Ancient Egypt</option>
                    <option value="Medieval Europe" <?php echo $selectedSection == 'Medieval Europe' ? 'selected' : ''; ?>>Medieval Europe</option>
                    <option value="Modern Art" <?php echo $selectedSection == 'Modern Art' ? 'selected' : ''; ?>>Modern Art</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="date" class="form-label">Reservation Date</label>
                <input type="text" class="form-control" id="date" name="date" value="<?php echo $selectedDate; ?>" required>
            </div>
            <div class="mb-3">
                <label for="time" class="form-label">Start Time</label>
                <select class="form-select" id="time" name="time" required>
                    <option value="">Select a time</option>
                    <?php foreach ($availableTimes as $time): ?>
                        <option value="<?php echo $time; ?>"><?php echo $time; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="persons" class="form-label">Number of Persons</label>
                <input type="number" class="form-control" id="persons" name="persons" required>
            </div>
            <div class="mb-3">
                <label for="payment" class="form-label">Payment Method</label>
                <select class="form-select" id="payment" name="payment" required>
                    <option value="">Select an option</option>
                    <option value="Cash">Cash</option>
                    <option value="VisaCard">VisaCard</option>
                    <option value="PayPal">PayPal</option>
                </select>
            </div><center>
            <button type="submit" name="action" value="make_reservation" class="btn btn-primary">Make Reservation</button></center>
        </form>
        
        <center>
        <a class="btn btn-danger" href="cancelres.php">Cancel a Reservation</a></center>
    </div>
    <center>
    <?php if ($isAdmin): ?>
<div>
    <form method="post">
        <h2>Edit Open and Close Time</h2>
        <input type="time" name="timeO" value="<?php echo $openTime; ?>" required>
        <input type="time" name="timeC" value="<?php echo $closeTime; ?>" required>
        <button type="submit" name="Ntime" class="btn btn-primary mt-2">Update Time</button>
    </form>
</div>
<?php endif; ?>
    </center>
                    </br>
    <div>
        <iframe src="/contactUs.php" width="100%" height="300" frameborder="0" scrolling="no" style="border:none; overflow:hidden;"></iframe>
    </div>
    <script>
                document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#date", {
                dateFormat: "Y-m-d",
                minDate: "today"
            });

            // Re-fetch available times when the date or section changes
            document.getElementById('date').addEventListener('change', function() {
                this.form.submit();
            });

            document.getElementById('section').addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>
    <style> 
    body {
            font-family: 'Playfair Display', serif;
        }
    .font {   
           font-weight: 700; 
           text-align: center;
       }
        </style>
</body>
</html>
