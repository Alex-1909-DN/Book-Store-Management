
<?php
require_once('db_credentials.php');
//connect to the database
//then confirm the connection otherwise return error
function db_connect()
{
    // Attempt to connect to the database using the credentials defined in db_credentials.php
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    // Check if the connection was successful
    if (mysqli_connect_errno()) {
    $msg = "Database connection failed: ";
    $msg .= mysqli_connect_error();
    $msg .= " (" . mysqli_connect_errno() . ")";
    exit($msg);
    }

    return $connection;
}
// Function to disconnect from the database
// This function closes the database connection if it is open
function db_disconnect($connection)
{
    if (isset($connection)) {
    mysqli_close($connection); // Close the connection
    }
}

?>