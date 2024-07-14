<?php
session_start();
require_once 'connection.php';

if (isset($_POST['Email']) && isset($_POST['Pass'])) {
    $email = $_POST['Email'];
    $password = $_POST['Pass'];

   
    $sql = "SELECT * FROM users WHERE user_email='$email'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error: " . $conn->error);
    }

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['user_password'])) {
            $_SESSION['user_id'] = $row['user_id']; 
            $_SESSION['username'] = $row['user_name'];
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['message'] = "Incorrect password. Please try again.";
        }
    } else {
        $_SESSION['message'] = "User not found. Please sign up.";
    }


    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script async src="https://cdn.jsdelivr.net/npm/es-module-shims@1/dist/es-module-shims.min.js" crossorigin="anonymous"></script>
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
<center>
    <div>
        <h3>WELCOME TO</h3>
        <h1>MODERN-MUSIUM</h1>
    </div>
    <div class="card border-light mb-4"></div>
    <form action="login.php" method="post">
        <div> <h1>Login</h1> </div>
        <div class="container form-container">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" name="Email" placeholder="Email" aria-label="Email">
                </div>
            </div>
    </br>
            <div class="row">
                <div class="col">
                    <input type="password" class="form-control" name="Pass" placeholder="Password" aria-label="Password">
                </div>
            </div>
            <div>
                <?php
                if(isset($_SESSION['message'])) {
                    echo '<p style="color: red;">' . $_SESSION['message'] . '</p>';
                    unset($_SESSION['message']);
                }
                ?>
            </div>
        </div>
     </div>
        <p id="message"></p>
        <div>
        
                <input type="reset" value="CLEAR" class="btn btn-secondary"/>
                <input type="submit" name="signup" value="SUBMIT" class="btn btn-primary"/>
           
        </div>
            </br>
    </form>
    <div>
        <iframe src="/contactUs.php" width="100%" height="300" frameborder="0" scrolling="no" style="border:none; overflow:hidden;"></iframe>
    </div>
</body>
<style> 
    body {
            font-family: 'Playfair Display', serif;
        }
    .font {   
           font-weight: 700; 
           text-align: center;
       }
        </style>
</html>
