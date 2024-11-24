
<?php
    // Connect to the database
    require_once('database.php');
    $db = db_connect();

    define('DISABLE_SESSION', true); 
    include 'header.php';

    // Access URL parameter
  if (!isset($_GET['id'])) { // Check if we get the id
    header("Location: update.php");
    }
    $id = $_GET['id'];

    // Prepare your query to get the updated book information
    $sql = "SELECT b.*, rv.review_text 
            FROM books b
            LEFT JOIN reviews rv ON b.id = rv.book_id
            WHERE b.id = '$id'";

    $result_set = mysqli_query($db, $sql);

    // Fetch the result
    $result = mysqli_fetch_assoc($result_set);
    ?>


<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
        name="description"
        content="This page displays the details of a specific book retrieved from the database. It retrieves the book's information, including title, author, publisher, ISBN, and overview, based on the provided `id` parameter in the URL."
    />
    <meta
        name="keywords"
        content="Bookstore, book, title, author, category, overview"
    />
    <title>Bookstore Show Page</title>
    <link rel="stylesheet" href="../public/stylesheet/styles.css" />
    </head>

    <body class = "show-page">

    <!-- Display the updated book data -->
    <div id="content">
        <div class = "head-show">
        <a class="back-link" href="main.php">Back to Main Page</a>
        <p>Your book's information has been saved!</p>
        </div>
        <div class="page show">
        <h1><?php echo $result['title']; ?></h1>

        <div class="attributes">
            <dl>
                <dt>Book Title</dt>
                    <dd><?php echo $result['title']; ?></dd>
            </dl>
            <dl>
                <dt>Author</dt>
                    <dd><?php echo $result['author']; ?></dd>
            </dl>
            <dl>
                <dt>Publisher</dt>
                    <dd><?php echo $result['publisher']; ?></dd>
            </dl>
            <dl>
                <dt>ISBN</dt>
                    <dd><?php echo $result['isbn']; ?></dd>
            </dl>
            <dl>
                <dt>Overview</dt>
                    <dd><?php echo isset($result['description']) ? $result['description'] : 'No Overview'; ?></dd>
            </dl>
        </div>

    </div>

    <?php include 'footer.php'; ?>
    </body>

</html>