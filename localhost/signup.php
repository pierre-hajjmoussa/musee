<?php
session_start();
require_once 'connection.php';

if(isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the user already exists
    $sql = "SELECT * FROM users WHERE user_email='$email' OR user_name='$username'";
    $result = $conn->query($sql);

    if (!$result) {
        die("Error in SELECT query: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        header("Location: signup.php?message=User already exists");
        exit();
    } else {
        // Insert the new user
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (user_name, user_email, user_password) VALUES ('$username', '$email', '$hashed_password')";
        if ($conn->query($sql) === TRUE) {
            header("Location: signup.php?message=Signup successful");
            exit();
        } else {
            die("Error in INSERT query: " . $conn->error);
        }
    }
}
?>

    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script async src="https://cdn.jsdelivr.net/npm/es-module-shims@1/dist/es-module-shims.min.js" crossorigin="anonymous"></script>
    <script type="importmap">
      {
        "imports": {
          "@popperjs/core": "https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/esm/popper.min.js",
          "bootstrap": "https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.esm.min.js"
        }
      }
      </script>
    <script type="module">
      import * as bootstrap from 'bootstrap'

      new bootstrap.Popover(document.getElementById('popoverButton'))
    </script>
    <title>Museum</title>
</head>
<style> 
    body {
            font-family: 'Playfair Display', serif;
        }
          .font {
           
            font-weight: 700; 
            text-align: center;
           
        }
   
        </style>
<body class="body" data-bs-theme="dark">
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

                                    <li><a class="nav-link" href="login.php">LOGIN</a></li>
                                    
                                <?php endif; ?>
                            </ul>
                        </li>
                </ul>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container text-center">
        <h3>WELCOME TO</h3>
        <h1>MODERN-Museum</h1>
        <div class="card border-light mb-4"></div>
        <h1>Sign Up</h1>
        <div class="container form-container">
        <form method="POST" action="signup.php" onsubmit="return validateForm()">
            <div class="card-body">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="repeatPassword">Repeat Password:</label>
                    <input type="password" class="form-control" id="repeatPassword" required>
                </div>
            </div>
            <p id="message"></p>
            <div>
                <input type="reset" value="CLEAR" class="btn btn-secondary"/>
                <input type="submit" id="submitButton" name="signup" value="SUBMIT" class="btn btn-primary"/>
            </div>
        </form>
        <p id="message">
    <?php 
    if (isset($_GET['message'])) {
        echo ($_GET['message']); 
    }
    ?>
    </p>
      
    <div>
        <iframe src="/contactUs.php" width="100%" height="300" frameborder="0" scrolling="no" style="border:none; overflow:hidden;"></iframe>
    </div>
    </div>
    <script>
        const passwordField = document.getElementById("password");
        const repeatPasswordField = document.getElementById("repeatPassword");
        const message = document.getElementById("message");
        const submitButton = document.getElementById("submitButton");

        passwordField.addEventListener("keyup", checkPasswordMatch);
        repeatPasswordField.addEventListener("keyup", checkPasswordMatch);

        function checkPasswordMatch() {
            const password = passwordField.value;
            const repeatPassword = repeatPasswordField.value;

            if (password !== repeatPassword) {
                message.textContent = "Passwords do not match!";
                submitButton.disabled = true;
            } else {
                message.textContent = "";
                submitButton.disabled = false;
            }
        }
    </script>
</body>
</html>
