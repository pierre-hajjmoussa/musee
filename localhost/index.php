<?php
require_once 'connection.php';
session_start();

if (isset($_SESSION['user_id'], $_SESSION['username'])) {
    $message1 = "Welcome, " . $_SESSION['username'] . "!";
    $admin = ($_SESSION['username'] === 'admin'); 
} else {
    $message1 = "Welcome!";
    $admin = false;
}
//getting desc of museum from table
$sql = "SELECT * FROM parag";
$result1 = $conn->query($sql);

if ($result1 && $result1->num_rows > 0) {
    $parag = $result1->fetch_assoc();
} else {
    $parag = array('description' => 'no description found'); 
}
//first section of photos
$photos = "SELECT * FROM photos";
$result2 = $conn->query($photos);
$photos = [];

if ($result2 && $result2->num_rows > 0) {
    while ($row = $result2->fetch_assoc()) {
        $photos[] = $row;
    }
}
$photo1 = $photos;
$photo2 = array_slice($photos, 3);
$photo3 = array_slice($photos, 6);
$counter1 = 0;
$counter2 = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['Nparag']) && $admin) {
        $Nparag = $_POST['parag'];
      $sql = "UPDATE parag SET description = '$Nparag'";
        $conn->query($sql);
         header("Location: index.php");
        exit;
    
    } elseif (isset($_POST['Nphoto']) && $admin) {
        $id = $_POST['id'];
     $Ndesc = $_POST['Pdesc'];
        $Nlink = $_POST['Plink'];
        $sql = "UPDATE photos SET description = '$Ndesc', link = '$Nlink' WHERE id = $id";
        $conn->query($sql);
        header("Location: index.php");
       
     exit;

    } elseif (isset($_POST['add']) && $admin) {
        $sql = "INSERT INTO photos (description, link) VALUES ('New Photo Description', 'link that ends with jpeg')";
        $conn->query($sql);
        header("Location: index.php");
        exit;
    } elseif (isset($_POST['delete']) && $admin) {
        if (isset($_POST['id'])) {
            $del = $_POST['id'];
            $sql = "DELETE FROM photos WHERE id = $del";
            $conn->query($sql);
            header("Location: index.php");
            exit;
            
    }
}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Museum</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
    .background-video {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 300px;
        object-fit: cover; 
        z-index: -1;
    }
    .image {
      width: 100%;
      height: 300px;
      overflow: hidden; 
    }

    .card-img-top {
     width: 100%;
     height: 100%;
     object-fit: cover; 
     object-position: center; 
    }
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
    .btn-custom {
        background-color: green;
        color: white;
        border-color: green;
    }
    .btn-custom:hover {
        background-color: darkgreen;
        border-color: darkgreen;
    }
    .card:hover {
     transform: scale(1.05); 
     transition: transform 0.3s ease;}
     
     img[src="https://www.freewebhostingarea.com/images/poweredby.png"] {
    display: none;
}
</style>
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
                            <a class="nav-link active" href="index.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="reserve.php">Tour</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="feedbacks.php">Feedbacks</a>
                        </li>
                        <?php if (isset($_SESSION['username'])): ?>
                                <?php if ($_SESSION['username'] == 'admin'): ?>
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
                    <span class="container mt-3">
                            <div class="d-flex justify-content-end">
                            <a class="btn btn-custom btn-sm" href="reserve.php">
                            <i class="fas fa-ticket-alt"></i> Tour
                        </a>
                    </span>
                   </div>    
                </div>
            </div>
        </nav>
        <video class="background-video" aria-hidden="true" tabindex="-1" preload="auto" autoplay loop muted playsinline>
    <source type="video/mp4" src="https://api-www.louvre.fr/sites/default/files/2024-04/Louvre%20-%20Home%20Tablette%20VDEF.mp4">
</video>
 </div>
    <center>
        <div class="title">
            <h3><?php echo $message1; ?></h3>
            <h1>MODERN-Museum</h1>
        </div>
        <h3>Primary Sections</h3>
        <div class="container mt-4">
    <div class="row">
        <?php foreach ($photo1 as $p1): ?>
            <?php if ($counter1 >= 3) break; ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                  <div class="image">
                       <img src="<?php echo $p1['link']; ?>" class="card-img-top">
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?php echo $p1['description']; ?></p>
                        <?php if ($admin): ?>
                            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                <input type="hidden" name="id" value="<?php echo $p1['id']; ?>">
                                <div class="mb-3">
                                    <textarea class="form-control" name="Pdesc" rows="3"><?php echo $p1['description']; ?></textarea>
                                    <input type="text" class="form-control mt-2" name="Plink" value="<?php echo $p1['link']; ?>">
                                    <button type="submit" name="Nphoto" class="btn btn-primary mt-2">Update Photo</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php $counter1++; ?>
        <?php endforeach; ?>
    </div>
</div>


        <h3>Random Items</h3>
        <div class="container mt-4">
    <div class="row">
        <?php foreach ($photo2 as $p2): ?>
            <?php if ($counter2 >= 3) break; ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                   <div class="image">
                       <img src="<?php echo $p2['link']; ?>" class="card-img-top">
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?php echo $p2['description']; ?></p>
                        <?php if ($admin): ?>
                            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                <input type="hidden" name="id" value="<?php echo $p2['id']; ?>">
                                <div class="mb-3">
                                    <textarea class="form-control" name="Pdesc" rows="3"><?php echo $p2['description']; ?></textarea>
                                    <input type="text" class="form-control mt-2" name="Plink" value="<?php echo $p2['link']; ?>">
                                    <button type="submit" name="Nphoto" class="btn btn-primary mt-2">Update Photo</button>
                                    <button type="submit" name="delete" class="btn btn-danger mt-2">Delete</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php $counter2++; ?>
        <?php endforeach; ?>
    </div>
</div>


<div class="container mt-4">
    <button id="Sbtn" class="btn btn-primary">Show more</button>
    <div id="hide" class="mt-3 d-none">
    <div class="container mt-4">
    <div class="row">
        <?php foreach ($photo3 as $p3): ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <div class="image">
                       <img src="<?php echo $p3['link']; ?>" class="card-img-top">
                    </div>
                    <div class="card-body">
                        <p class="card-text"><?php echo $p3['description']; ?></p>
                        <?php if ($admin): ?>
                            <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                                <input type="hidden" name="id" value="<?php echo $p3['id']; ?>">
                                <div class="mb-3">
                                    <textarea class="form-control" name="Pdesc" rows="3"><?php echo $p3['description']; ?></textarea>
                                    <input type="text" class="form-control mt-2" name="Plink" value="<?php echo $p3['link']; ?>">
                                    <button type="submit" name="Nphoto" class="btn btn-primary mt-2">Update Photo</button>
                                    <button type="submit" name="delete" class="btn btn-danger mt-2">Delete</button>
                                </div>
                            </form>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <button id="Lbtn" class="btn btn-primary d-none">Show less</button>
</div>
</div>
</div>
        <?php if ($admin): ?>
            <div class="row mt-4">
                <div class="col-md-12">
                    <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <button type="submit" name="add" class="btn btn-success">Add New Photo</button>
                    </form>
                </div>
            </div>
        <?php endif; ?>

        <hr>

        <div class="row mt-4">
            <div class="col-md-12">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="mb-3">
                            <div class="text" style="width: 80%; max-width: 100%;"><?php echo isset($parag['description']) ? $parag['description'] : ''; ?></div>
                        <?php if ($admin): ?>
                            <textarea class="form-control" name="parag" rows="7" style="width: 80%; max-width: 100%;"><?php echo isset($parag['description']) ? $parag['description'] : ''; ?></textarea>
                            <button type="submit" name="Nparag" class="btn btn-primary mt-2">Update Museum Description</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </br>    
                        
    <div>
        <iframe src="/contactUs.php" width="100%" height="300" frameborder="0" scrolling="no" style="border:none; overflow:hidden;"></iframe>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script>
    // JavaScript to handle button clicks
    document.getElementById('Sbtn').addEventListener('click', function() {
        // Show the hidden content
        document.getElementById('hide').classList.remove('d-none');
        // Toggle button visibility
        document.getElementById('Sbtn').classList.add('d-none');
        document.getElementById('Lbtn').classList.remove('d-none');
    });

    document.getElementById('Lbtn').addEventListener('click', function() {
        // Hide the content
        document.getElementById('hide').classList.add('d-none');
        // Toggle button visibility
        document.getElementById('Sbtn').classList.remove('d-none');
        document.getElementById('Lbtn').classList.add('d-none');
    });
</script>
</html>
