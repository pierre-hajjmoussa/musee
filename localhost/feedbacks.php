<?php
require_once 'connection.php';
session_start();

if (isset($_SESSION['user_id'], $_SESSION['username'])) {
    $userId = ($_SESSION['user_id']);
    $user = ($_SESSION['username']);
    $isAdmin = ($_SESSION['username'] === 'admin'); 
} else {
    $userId = NULL;
    $isAdmin = false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'deleteFeedback') {
    $feedbackId = $_POST['feedbackId'];

    if ($isAdmin || hisFeedback($userId, $feedbackId)) {
        $deleteQuery = "DELETE FROM feedbacks WHERE id = $feedbackId";
        if ($conn->query($deleteQuery) === TRUE) {
            // Feedback deleted successfully
            header("Location: feedbacks.php");
            exit;
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Permission denied.";
    }
}

// Function to check if the current user is the owner of the feedback
function hisFeedback($userId, $feedbackId) {
    global $conn;
    $query = "SELECT * FROM feedbacks WHERE id = $feedbackId AND user_id = $userId";
    $result = $conn->query($query);
    return ($result->num_rows > 0);
}

// Handle form submission for adding feedback (only if logged in)
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['action']) && $userId) {
    $content = $_POST['content'];

    // Insert the new feedback
    $insertQuery = "INSERT INTO feedbacks (user_id, date, time, content) VALUES ($userId, CURDATE(), CURTIME(), '$content')";

    if ($conn->query($insertQuery) === TRUE) {
        // Feedback added successfully
        header("Location: feedbacks.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Fetch feedbacks with user names using a join
$query = "SELECT feedbacks.id, feedbacks.date, feedbacks.time, feedbacks.content, users.user_name 
          FROM feedbacks 
          INNER JOIN users ON feedbacks.user_id = users.user_id 
          ORDER BY feedbacks.date DESC, feedbacks.time DESC";
$result = $conn->query($query);

// Array to hold feedbacks
$feedbacks = [];
while ($row = $result->fetch_assoc()) {
    $feedbacks[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedbacks</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
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
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reserve.php">Tour</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">Feedbacks</a>
                    </li>
                    <li class="nav-item">
                    <?php if (isset($_SESSION['username'])): ?>
                                <?php if ($isAdmin): ?>
                                    <li><a class="nav-link" href="admin.php">ADMIN</a></li>
                                <?php endif; ?>
                                <li><a class="nav-link" href="logout.php">Logout</a></li>
                                <?php else: ?>
                                    <li class="nav-item dropdown">
                                    <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">Users</a>
                                    <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="signup.php">Sign up</a></li>
                                    <li><a class="dropdown-item" href="login.php">Login</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
<style>
     body {
            font-family: 'Playfair Display', serif;
        }
    .font {
           
            font-weight: 700; 
            text-align: center;
           
        }
</style>
<center>
    <div>
        <h1>MODERN-Museum</h1>
        <h1>Feedbacks</h1>


        <?php if ($userId): ?>
            <div class="container form-container">
                <div class="row">
                    <div class="col-md-6 offset-md-3">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="content" class="form-label">Your Feedback</label>
                                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit Feedback</button>
                        </form>
                    </div>
                </div>
            </div>
            <br>
        <?php endif; ?>

        <div class="container form-container">
            <div class="row row-cols-md-4 g-4">
                <?php foreach ($feedbacks as $feedback): ?>
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $feedback['user_name']; ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?php echo "Date: " . $feedback['date'] . " | Time: " . $feedback['time']; ?></h6>
                                <p class="card-text"><?php echo $feedback['content']; ?></p>
                                <?php if ($isAdmin || ($userId && hisFeedback($userId, $feedback['id']))): ?>
                                    <form class="delete-form" method="POST">
                                        <input type="hidden" name="action" value="deleteFeedback">
                                        <input type="hidden" value="<?php echo $feedback['id']; ?>" name="feedbackId">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
 </br>
    
                                
 <div>
        <iframe src="/contactUs.php" width="100%" height="300" frameborder="0" scrolling="no" style="border:none; overflow:hidden;"></iframe>
    </div>
</center>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
