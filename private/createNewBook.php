<?php
// Include the database connection and header files
require_once('database.php');
include('header.php');
$db = db_connect();
// Check if the form was submitted using the POST method
if ($_SERVER['REQUEST_METHOD'] =='POST') {
    // Retrieve the input values from the form
    $bookTitle = $_POST['bookTitle'];
    $bookAuthor = $_POST['bookAuthor'];
    $bookPublisher = $_POST['bookPublisher'];
    $bookISBN = $_POST['bookISBN'];
    $bookCategory = $_POST['bookCategory'];
    $bookLink = $_POST['bookLink'];
    $bookDescription = $_POST['bookDescription'];
    // Get the user ID from the session
    $userID = $_SESSION['user_id'];

    // Escape the input values to prevent SQL injection
    $bookTitle = mysqli_real_escape_string($db, $bookTitle);
    $bookAuthor = mysqli_real_escape_string($db, $bookAuthor);
    $bookPublisher = mysqli_real_escape_string($db, $bookPublisher);
    $bookISBN = mysqli_real_escape_string($db, $bookISBN);
    $bookCategory = mysqli_real_escape_string($db, $bookCategory);
    $bookLink = mysqli_real_escape_string($db, $bookLink);
    $bookDescription = mysqli_real_escape_string($db, $bookDescription);


    // Query the database to get the category ID based on the name
    $selectCategorySql = "SELECT id FROM categories WHERE name = '$bookCategory'";
    $resultCategory = mysqli_query($db, $selectCategorySql);
    $categoryId=null;
    // Check if a valid category was found
    if (mysqli_num_rows($resultCategory) > 0) {
        $categoryRow = mysqli_fetch_assoc($resultCategory);
        $categoryId = $categoryRow['id'];
    } else {
        $_SESSION['error_message'] = "Invalid category selected.";
        header("Location: addNewBook.php");
        exit;
    }

   // Check if the book already exists in the database
    $selectBookSql = "SELECT * FROM books WHERE (author = '$bookAuthor' AND title = '$bookTitle') OR isbn = '$bookISBN'";
    $result_select = mysqli_query($db, $selectBookSql);
    if (mysqli_num_rows($result_select) > 0) {
        // Set an error message and redirect if the book already exists
        $_SESSION['error_message'] = "This book already exists in the Book Store.";
        header("Location: addNewBook.php");
        exit;
    } else {
        // Insert the new book record into the database
        $insertBookSql = "INSERT INTO books (title, author, publisher, isbn, description, link, category_id) 
        VALUES ('$bookTitle', '$bookAuthor', '$bookPublisher', '$bookISBN','$bookDescription', '$bookLink', '$categoryId')";
        $resultBookSql = mysqli_query($db, $insertBookSql);

        // Check if the insertion was successful
        if ($resultBookSql) {
            // Get the ID of the newly inserted book
            $newBookId = mysqli_insert_id($db);

            // Redirect to the show.php page with the newly inserted book ID
            header("Location: show.php?id=" . $newBookId);
            exit;
        } else {
            // Handle any errors during the insertion
            $_SESSION['error_message'] = "Error: Failed to add the book. Please try again.";
            header("Location: addNewBook.php");
            exit;
        }
    }
    db_disconnect($db); // Close the database connection
}
?>