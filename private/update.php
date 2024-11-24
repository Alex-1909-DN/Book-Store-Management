
<?php
require_once('database.php');
$db = db_connect();

// Disable session for this script
define('DISABLE_SESSION', true); 
    include 'header.php';

//check if we get the id
if (!isset($_GET['id'])) { 
  header("Location:  main.php");
}
$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // Escape special characters to prevent SQL injection
  $title = mysqli_real_escape_string($db, $_POST['bookTitle']);
  $author = mysqli_real_escape_string($db, $_POST['bookAuthor']);
  $publisher = mysqli_real_escape_string($db, $_POST['bookPublisher']);
  $isbn = mysqli_real_escape_string($db, $_POST['bookISBN']);
  $overview = mysqli_real_escape_string($db, $_POST['bookOverview']);
  $link = mysqli_real_escape_string($db, $_POST['bookLink']);
  $name = mysqli_real_escape_string($db, $_POST['bookCategory']);
  $alt_text = mysqli_real_escape_string($db, $_POST['bookAltText']);
  $review_text = mysqli_real_escape_string($db, $_POST['bookReview']);

    // Process file upload
    if (isset($_FILES['bookImage']) && $_FILES['bookImage']['error'] == 0) {
      // Define the target directory (relative path for saving the image)
      $target_dir = "../public/images/";

      // Get the uploaded file's name
      $file_name = basename($_FILES['bookImage']['name']);
      $target_file = $target_dir . $file_name;

      // Move the uploaded file to the target directory
      if (move_uploaded_file($_FILES['bookImage']['tmp_name'], $target_file)) {
          // Store the relative path in the database (relative to the 'public' folder for web access)
          $path_name = "../public/images/" . $file_name;
      } else {
          // Use default image if upload fails
          $path_name = '../public/images/book10.jpg';
      }
  } else {
      // Use default image if no file is uploaded
      $path_name = '../public/images/book10.jpg';
  }

// Update the book in the database
$sql = "UPDATE books 
      SET 
          title = '$title',
          author = '$author',
          publisher = '$publisher',
          isbn = '$isbn',
          description = '$overview',
          link = '$link',
          path_name = '$path_name',
          alt_text = '$alt_text'
      WHERE id = '$id'";

$result = mysqli_query($db, $sql);

if ($result) {
  // Update the review (if applicable)
  $review_sql = "UPDATE reviews 
                SET review_text = '$review_text'
                WHERE id = '$id'";
  mysqli_query($db, $review_sql);

  // Redirect to the book details page
  header("Location: show.php?id=$id");
  exit();
} else {
  echo "Error updating the record: " . mysqli_error($db);
}
} else {
// Display the current book information
$sql = "SELECT b.*, rv.review_text
        FROM books b
        LEFT JOIN reviews rv ON b.id = rv.id
        WHERE b.id = '$id'";
$result_set = mysqli_query($db, $sql);
$result = mysqli_fetch_assoc($result_set);

if (!$result) {
  header("Location: main.php");
  exit();
}

    // Fetch current category
    $category_sql = "SELECT id, name FROM categories";
    $categories = mysqli_query($db, $category_sql);
}

?>



<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
        name="description"
        content="This page allows users to update book information in the database, including title, author, publisher, ISBN, category, description, and book cover."
    />
    <meta
        name="keywords"
        content="Bookstore, book, title, author, category, overview, publisher"
    />
    <title>Bookstore Update Page</title>
    <link rel="stylesheet" href="../public/stylesheet/styles.css" />
  </head>
  <body class = "update-page">
    
    <main>
      <section id="book-update" >
        <h2>Update Your Book</h2>
        <form action="update.php?id=<?php echo ($id); ?>" method="post" enctype="multipart/form-data">
          <label for="bookTitle">Book Title</label>
          <input
            type="text"
            id="bookTitle"
            name="bookTitle"
            value = "<?php echo ($result['title']); ?>"
            required
          />

          <label for="bookAuthor">Author</label>
          <input
            type="text"
            id="bookAuthor"
            name="bookAuthor"
            value = "<?php echo ($result['author']); ?>"
            required
          />

          <label for="bookPublisher">Publisher</label>
          <input
            type="text"
            id="bookPublisher"
            name="bookPublisher"
            value = "<?php echo ($result['publisher']); ?>"
            required
          />

          <label for="bookISBN">ISBN</label>
          <input
            type="text"
            id="bookISBN"
            name="bookISBN"
            value = "<?php echo ($result['isbn']); ?>"
            required
          />


          <!-- Category -->
          <label for="bookCategory">Category</label>
          <select id="bookCategory" name="bookCategory" required>
          <?php while ($category = mysqli_fetch_assoc($categories)) : ?>
            <option value="<?php echo $category['id']; ?>" 
            <?php echo $category['id'] == $result['category_id'] ? 'selected' : ''; ?>>
            <?php echo ($category['name']); ?>
            </option>
            <?php endwhile; ?>
          </select>

          <!-- Book Link -->
          <label for="bookLink">Book Link</label>
          <input
            type="url"
            id="bookLink"
            name="bookLink"
            required
            value = "<?php echo ($result['link']); ?>"
          />

          <!-- Book Image Path -->
          <img src="<?php echo $result['path_name']; ?>" alt="<?php echo $result['alt_text']; ?>" width="100" />
          <label for="bookImage">Upload New Image</label>
          <input type="file" id="bookImage" name="bookImage" accept="image/*" />

          <!-- Alternative Text -->
          <label for="bookAltText">Alternative Text</label>
          <input
            type="text"
            id="bookAltText"
            name="bookAltText"
            value = "<?php echo ($result['alt_text']); ?>"
            required
          />


          <label for="bookOverview">Book Description</label>
          <textarea
            id="bookOverview"
            name="bookOverview"
            required
          ><?php echo ($result['description']); ?></textarea>


          <button type="submit" class="action-button">Update Book</button>
        </form>
      </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
  </body>
</html>
