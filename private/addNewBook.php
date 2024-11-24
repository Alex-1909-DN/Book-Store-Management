<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
      name="description"
      content="This page enables users to add new book to the Bookstore."
    />
    <meta
      name="keywords"
      content="Bookstore, book, title, author, category, ISBN, Publisher"
    />
    <title>Bookstore Addnew Page</title>
    <link rel="stylesheet" href="../public/stylesheet/styles.css" />
  </head>
  <body class ="addnew-page">
    <!-- Navigation Bar -->
    <?php 
    include 'header.php';
    // Retrieve error message if set
    if (isset($_SESSION['error_message'])) {
      $error_message = $_SESSION['error_message'];
      unset($_SESSION['error_message']); 
    }
    ?>
    <!-- Main Content -->
    <main>
      <section id="add-book-section">
        <h2>Add a New Book</h2>

        <?php if (isset($error_message)): ?>
            <div class="warning">
              <?php echo $error_message; ?>
            </div>
          <?php endif; ?>

        <form action="createNewBook.php" method="POST" id="add-book-form">
          <!-- Book Title -->
          <label for="bookTitle">Book Title</label>
          <input
            type="text"
            id="bookTitle"
            name="bookTitle"
            required
            placeholder="Enter book title"
          />

          <!-- Book Author -->
          <label for="bookAuthor">Author</label>
          <input
            type="text"
            id="bookAuthor"
            name="bookAuthor"
            required
            placeholder="Enter author's name"
          />

          <!-- Publisher -->
          <label for="bookPublisher">Publisher</label>
          <input
            type="text"
            id="bookPublisher"
            name="bookPublisher"
            required
            placeholder="Enter publisher name"
          />

          <!-- ISBN -->
          <label for="bookISBN">ISBN</label>
          <input
            type="text"
            id="bookISBN"
            name="bookISBN"
            required
            placeholder="Enter ISBN"
          />

          <!-- Category -->
          <label for="bookCategory">Category</label>
          <select id="bookCategory" name="bookCategory" required>
            <option value="" disabled selected>Select a category</option>
            <option value="Science Fiction" >Science Fiction</option>
            <option value="Mystery">Mystery</option>
            <option value="Fantasy">Fantasy</option>
          </select>

          <!-- Book Link -->
          <label for="bookLink">Book Link</label>
          <input
            type="url"
            id="bookLink"
            name="bookLink"
            required
            placeholder="Enter a link to the book"
          />


          <!-- Book Description -->
          <label for="bookDescription">Book Description</label>
          <textarea
            id="bookDescription"
            name="bookDescription"
            rows="4"
            required
            placeholder="Enter book description"
          ></textarea>

          <!-- Submit Button -->
          <button type="submit" class="button">Add Book</button>
        </form>
      </section>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
  </body>
</html>
