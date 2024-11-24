<?php
// Including database connection and header files
require_once('database.php');
include ('header.php');

$db = db_connect();

// Check if the form is submitted via POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // Collect user input from the signup form
    $name = $_POST['name']; 
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    // Check if the username already exists in the database
    $selectUsernamesql = "SELECT * FROM users WHERE username = '$username'";
    $result_select = mysqli_query($db, $selectUsernamesql);
    if (mysqli_num_rows($result_select) > 0){
        // If username exists, display an error message and redirect to signup page
        $_SESSION['error_message'] = "Username already exists. Please choose another username.";
        header("Location: signup.php");
        exit;
    } else {
        // Insert new user into the database
        $insertsql = "INSERT INTO users (name, email, username, password) VALUES ('$name', '$email', '$username', '$password')";
        $result_insert = mysqli_query($db, $insertsql);
        // Check if the insertion was successful
        if ($result_insert){
            header("Location: ../public/index.php"); // Redirect to the homepage if registration is successful
            exit;
        }else {
            // If there was an error during registration, display an error message
            $_SESSION['error_message'] = "There was an error with the registration. Please try again.";
            header("Location: signup.php");
            exit;
        }
    }
    db_disconnect($db); // Disconnect from the database
}
?>