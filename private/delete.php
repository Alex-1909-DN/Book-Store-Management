
<?php
    require_once('database.php');
    $db = db_connect();

    // Disable session for this script
    define('DISABLE_SESSION', true); 
    include 'header.php';

    if (!isset($_GET['id'])) { 
        // Redirect if no ID is provided
        header("Location: main.php");
        exit();
    }

    $id = $_GET['id'];

    // Handle deletion upon form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $sql = "DELETE FROM books WHERE id = '$id'";
        $result = mysqli_query($db, $sql);

        if ($result) {
            // Also delete associated reviews and ratings if applicable
            $delete_reviews = "DELETE FROM reviews WHERE id = '$id'";
            $delete_ratings = "DELETE FROM ratings WHERE id = '$id'";
            mysqli_query($db, $delete_reviews);
            mysqli_query($db, $delete_ratings);

            // Redirect to main page after successful deletion
            header("Location: main.php");
            exit();
        } else {
            echo "<p class='error'>Error deleting the record: " . mysqli_error($db) . "</p>";
        }
    } else {
        // Retrieve book details for confirmation
        $sql = "SELECT * FROM books WHERE id = '$id'";
        $result_set = mysqli_query($db, $sql);
        $result = mysqli_fetch_assoc($result_set);

        if (!$result) {
            header("Location: main.php");
            exit();
        }
    }
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta
        name="description"
        content="This page enables users to a delete a book from the database along with its associated reviews and ratings."
    />
    <meta
        name="keywords"
        content="Bookstore, book, title, author, category, ISBN, Publisher"
    />
    <title>Bookstore Delete Page</title>
    <link rel="stylesheet" href="../public/stylesheet/styles.css" />
</head>
<body class="delete-page">
    <!-- Navigation Bar -->
    <main>
        <section id="book-delete">
            <h2>Delete Book</h2>
            <div class="delete-confirm">
            <p>Are you sure you want to delete the following book?</p>
            </div>
            <div class = "delete-detail">
            <p><strong>Title:</strong> <em><?php echo htmlspecialchars($result['title']); ?></em></p>
            <p><strong>Author:</strong> <?php echo htmlspecialchars($result['author']); ?></p>
            <p><strong>Publisher:</strong> <?php echo htmlspecialchars($result['publisher']); ?></p>
            <p><strong>ISBN:</strong> <?php echo htmlspecialchars($result['isbn']); ?></p>
            <p><strong>Overview:</strong> <?php echo htmlspecialchars($result['description']); ?></p>
            </div>
            <form action="delete.php?id=<?php echo $id; ?>" method="post">
                <button type="submit" class="delete-button">CONFIRM DELETE</button>
            </form>

            <a class="back-link" href="main.php"><span class="cancel-button">CANCEL AND GO BACK</span></a>
        </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
</body>
</html>