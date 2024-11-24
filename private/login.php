
<?php
session_start();
require_once('database.php');
$db = db_connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($db, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        if ($password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            header("Location: main.php?id={$user['id']}");
            exit;
        } else {
            // Set specific error for invalid password
            $_SESSION['password_error'] = "Incorrect password";
            header("Location: ../public/index.php");
            exit;
        }
    } else {
        // Set specific error for invalid username
        $_SESSION['username_error'] = "Invalid username";
        header("Location: ../public/index.php");
        exit;
    }

    db_disconnect($db);
}
?>