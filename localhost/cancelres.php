<?php
require_once 'connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
//show reservations
$userId = $_SESSION['user_id'];
$isAdmin = ($_SESSION['username'] === 'admin'); 

if ($isAdmin){ 
$sql = "SELECT reservation_id, user_id, section, dater, time1, time2, persons, payment, status
        FROM reservations ORDER BY dater";
}else {
    $sql = "SELECT reservation_id, user_id, section, dater, time1, time2, persons, payment, status
    FROM reservations 
    WHERE user_id = '$userId'";
}
        
$result = $conn->query($sql);

$reservations = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservations[] = $row;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reservation_id'])) {
    $reservationId = $_POST['reservation_id'];
    $sql = "UPDATE reservations SET status = 'cancelled' WHERE reservation_id = $reservationId";
    if ($conn->query($sql) === TRUE) {
        header("Location: cancelres.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Your Reservations</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body  class="body" data-bs-theme="dark">
<style> 
    body {
            font-family: 'Playfair Display', serif;
        }
    .font {
           
           font-weight: 700; 
           text-align: center;
          
       }
   .title {
       position: relative;
       z-index: 1;
       color: white;
       text-align: center;
       margin-top: 150px; 
   }
        </style>
<div class="container">
    <h1>Your Reservations</h1>
    <?php if (count($reservations) > 0): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Reservation Number</th>
                    <th>User Id</th>
                    <th>Section Name</th>
                    <th>Date of tour</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Number of Persons</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($reservations as $reserv): ?>
                    <tr>
                        <td><?php echo $reserv['reservation_id']; ?></td>
                        <td><?php echo $reserv['user_id']; ?></td>
                        <td><?php echo $reserv['section']; ?></td>
                        <td><?php echo $reserv['dater']; ?></td>
                        <td><?php echo $reserv['time1']; ?></td>
                        <td><?php echo $reserv['time2']; ?></td>
                        <td><?php echo $reserv['persons']; ?></td>
                        <td><?php echo $reserv['payment']; ?></td>
                        <td><?php echo $reserv['status']; ?></td>
                        <td>
                            <?php if ($reserv['status'] === 'active'): ?>
                                <form method="POST" action="cancelres.php" style="display: inline;">
                                    <input type="hidden" name="reservation_id" value="<?php echo $reserv['reservation_id']; ?>">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this reservation?');">Cancel</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>You have no reservations.</p>
    <?php endif; ?>
    <a href="reserve.php" class="btn btn-primary">Make a New Reservation</a>
    <a href="index.php" class="btn btn-secondary">Back to Home</a>
</div>
<div></br></div>
<div>
        <iframe src="/contactUs.php" width="100%" height="300" frameborder="0" scrolling="no" style="border:none; overflow:hidden;"></iframe>
    </div>
</body>
</html>
