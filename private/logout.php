
<?php
// Start a new or resume an existing session
session_start();
// Unset all session variables to clear session data
session_unset();
// Destroy the session to ensure user logout
session_destroy();
// Redirect the user to the homepage after logout
header("Location: ../public/index.php");
exit;
?>