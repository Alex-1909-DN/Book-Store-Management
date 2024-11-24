
<?php
session_start();
require_once('database.php');
$db = db_connect();
// Default username as 'Guest'
$username = "Guest";

// If user is logged in, fetch their username
if (isset($_SESSION['user_id'])) {
    $id = $_SESSION['user_id'];

    // Query the database to fetch the username corresponding to the user's ID
    $sql = "SELECT username FROM users WHERE id = $id";
    $result_set = mysqli_query($db, $sql);
    $result = mysqli_fetch_assoc($result_set);

    // If a valid result is returned, update the username variable
    if ($result) {
        $username = htmlspecialchars($result['username']);
    }
}
?>

<!-- Navigation bar -->
<nav class="navbar">
    <h1>Bookstore</h1>
    <!-- User options: home link, username display, and sign-out button -->
    <div class="user-options">
        <a href="main.php" class="home-link">Home</a>
        <span class="user-initials"><?php echo $username;?></span>
        <!-- Sign-out form with a button to log out -->
        <form action="logout.php" method="post">
            <button type="submit" class="signout-button">Sign out</button>
        </form>
    </div>
</nav>