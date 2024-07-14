<?php
require_once 'connection.php';
session_start();
if (!(isset($_SESSION['user_id'], $_SESSION['username']) && $_SESSION['username'] === 'admin')) {
    header("Location: login.php");
    exit;
}

function getUsers($conn) {
    $query = "SELECT * FROM users ORDER BY user_name ASC";
    $result = $conn->query($query);
    $users = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    return $users;
}

function updateUser($conn, $userId, $username, $email, $password) {
    $query = "UPDATE users SET user_name = '$username', user_email = '$email', user_password = '$password' WHERE user_id = $userId";
    $conn->query($query);
    return true;
}

function deleteUser($conn, $userId) {
    $query = "DELETE FROM users WHERE user_id = $userId";
    $conn->query($query);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_user'])) {
    $userIdToDelete = $_POST['user_id'];
    deleteUser($conn, $userIdToDelete);
    header("Location: admin.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_user'])) {
    $userIdToEdit = $_POST['user_id'];
    $username = $_POST['user_name'];
    $email = $_POST['user_email'];
    $password = $_POST['user_password'];
    updateUser($conn, $userIdToEdit, $username, $email, $password);
    header("Location: admin.php");
    exit;
}

$users = getUsers($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<style>
    .fixed-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
    }
</style>
<body class="body" data-bs-theme="dark">
    <div class="container">
        <h1>Admin Page</h1>
        <h2>Users</h2>
        <p id="error">
        <?php 
         if (isset($_GET['error'])) {
            echo htmlspecialchars($_GET['error']); 
            }
        ?>
    </p>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['user_id']; ?></td>
                        <td><?php echo $user['user_name']; ?></td>
                        <td><?php echo $user['user_email']; ?></td>
                        <td>
                            <button type="button" class="btn btn-primary edit-user" data-user-id="<?php echo $user['user_id']; ?>" data-user-name="<?php echo $user['user_name']; ?>" data-user-email="<?php echo $user['user_email']; ?>" data-bs-toggle="modal" data-bs-target="#useredit">
                                Edit
                            </button>
                            <?php if ($user['user_name'] !== 'admin'): ?>
                                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>" style="display: inline;">
                                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                                    <button type="submit" name="delete_user" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete <?php echo $user['user_name']; ?>?');">Delete</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="index.php" class="btn btn-primary fixed-button">Back to Home</a>
    </div>
    <div>
        <?php if (isset($_SESSION['user_id'], $_SESSION['username'])): ?>
            <a href="logout.php" class="btn btn-primary fixed-logout" style="position: fixed; bottom: 70px; right: 20px; z-index: 1000;">Logout</a>
        <?php endif; ?>
    </div>
    <div class="modal fade" id="useredit" tabindex="-1" aria-labelledby="edit" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                    <div class="modal-header">
                        <h5 class="modal-title" id="edit">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="editUserId" name="user_id">
                        <div class="mb-3">
                            <label for="editUsername" class="form-label">Username</label>
                            <input type="text" class="form-control" id="editUsername" name="user_name">
                        </div>
                        <div class="mb-3">
                            <label for="editEmail" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="editEmail" name="user_email">
                        </div>
                        <div class="mb-3">
                            <label for="editPassword" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="editPassword" name="user_password">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="edit_user" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var editButtons = document.querySelectorAll('.edit-user');
        editButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var userId = button.getAttribute('data-user-id');
                var username = button.getAttribute('data-user-name');
                var email = button.getAttribute('data-user-email');
                document.getElementById('editUserId').value = userId;
                document.getElementById('editUsername').value = username;
                document.getElementById('editEmail').value = email;
            });
        });
    </script>
</body>
</html>