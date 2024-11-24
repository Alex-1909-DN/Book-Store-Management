<?php
require_once('database.php');
session_start();
$db = db_connect();
// Check if the user is logged in by verifying the session variable
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

// Handle the form submission using the POST method
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    // Retrieve the rating, review, and book ID from the POST data and cast them to the correct data types
    $rating = (int)$_POST['rating']; 
    $rating = (int)$_POST['rating']; 
    $review = $_POST['review'];
    $bookId = (int)$_POST['book_id'];
    $userId = (int)$_SESSION['user_id'];

    // Check if any of the required fields are empty and terminate with an error message if so
    if (empty($bookId) || empty($rating) || empty($review)) {
        die("Error: Missing required fields.");
    }

    // Escape special characters in the review text to avoid SQL syntax errors
    $review = mysqli_real_escape_string($db, $review);


    // SQL query to insert the review data into the reviews table
    $reviewsql = "INSERT INTO reviews(book_id, user_id, review_text) VALUES ('$bookId', '$userId', '$review')";
    $resultReviewsql = mysqli_query($db, $reviewsql);

    // SQL query to insert the rating data into the ratings table
    $ratingsql = "INSERT INTO ratings( book_id, user_id, rating) VALUES('$bookId','$userId', '$rating') ";
    $resultRatingsql = mysqli_query($db, $ratingsql);
    // If both the review and rating were successfully inserted, show an alert and redirect the user
    if ($resultReviewsql && $resultRatingsql){
        header("Location: main.php"); // Redirect to the main page
        exit;
    } else {
        // If there was an issue submitting the review or rating, terminate with an error message
        die("Error: Failed to submit review or rating.");
    }
} else {
    // If the request method is not POST, redirect the user to the book detail page
    header("Location: detail.php");
    exit;
}
db_disconnect($db);
?>