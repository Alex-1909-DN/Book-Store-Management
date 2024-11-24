
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
        name="description"
        content="This page his script displays the detailed information of a specific book, including its cover, title, author, publisher, ISBN, and description. It also provides a form for users to rate and review the book. The reviews are fetched from the database and displayed below the book details, showing the reviewer's username, rating (represented by stars), and review text."
    />
    <meta
        name="keywords"
        content="Bookstore, book, title, author, category, ISBN, Publisher, review, rating, Overview"
    />
    <title>Bookstore Detail Page</title>
    <link rel="stylesheet" href="../public/stylesheet/styles.css" />
  </head>
  <body>
    <!-- Navigation Bar -->
    <?php 
    //connect to the database
    require_once('database.php');
    include 'header.php';
    $db = db_connect();

    // Check if the book ID is set in the URL, otherwise redirect to the main page
    if (!isset($_GET['id'])){
      header("Location: main.php");
      EXIT;
    }
    $id = $_GET['id'];

    // SQL query to fetch book details along with its category
    $selectBooksql = "SELECT b.*, c.name FROM books b 
    INNER JOIN categories c ON b.category_id = c.id 
    WHERE b.id = $id";
    $result_set = mysqli_query($db,$selectBooksql);
    // Fetch the result as an associative array
    $result = mysqli_fetch_assoc($result_set);
    ?>

    <main>
      <section id="book-detail" data-id = "<?php echo $id; ?>">
        <div class="book-cover">
          <!-- Display book cover image -->
          <img src="<?php echo htmlspecialchars($result['path_name']); ?>" alt="<?php echo htmlspecialchars($result['alt_text']); ?>" />
        </div>
        <div class="book-info">
          <!-- Display book details such as title, author, publisher, ISBN, and description -->
          <h2 id="bookTitle"><?php echo htmlspecialchars($result['title']); ?></h2>
          <p id="bookAuthor">Author: <?php echo htmlspecialchars($result['author']);?></p>
          <p id="bookPublisher">
            Publisher: <?php echo htmlspecialchars($result['publisher']);?>
          </p>
          <p id="bookISBN">ISBN: <?php echo htmlspecialchars($result['isbn']);?></p>
          <div class="overview">
            <h3>Overview</h3>
            <p id="bookOverview">
            <?php echo htmlspecialchars($result['description']);?>
            </p>
          </div>
          
      <!-- Rating & Review Form -->
      <section id="rate-review">
        <h3>Rate and Review this Book</h3>
        <form action="createReviewRating.php" method="POST">
          <input type="hidden" name="book_id" value="<?php echo $id; ?>" />
          <div class="rating">
            <label for="rating">Your Rating: </label>
            <select name="rating" id="rating" required>
              <option value="" disabled selected>Select a rating</option>
              <option value="5">★★★★★</option>
              <option value="4">★★★★☆</option>
              <option value="3">★★★☆☆</option>
              <option value="2">★★☆☆☆</option>
              <option value="1">★☆☆☆☆</option>
            </select>
          </div>
          <div class="review">
            <label for="review">Your Review:</label>
            <textarea name="review" id="review" rows="4" required></textarea>
          </div>
          <button type="submit">Submit Review</button>
        </form>
      </section>
        </div>
      </section>

<!-- Reviews Section -->
    <section id="reviews">
      <h3>User Reviews</h3>

      <?php
      // SQL query to fetch user reviews and ratings for the book
      $userReviewsql = "SELECT rv.review_text, r.rating, u.username, rv.created_at, r.created_at
      FROM reviews rv
      JOIN users u ON rv.user_id = u.id
      JOIN ratings r ON rv.book_id = r.book_id AND rv.user_id = r.user_id
      WHERE rv.book_id = $id
      AND rv.created_at = r.created_at";
      $resultUserReview_set = mysqli_query($db, $userReviewsql);
      // Check if any reviews exist for this book
      if ($resultUserReview_set && mysqli_num_rows($resultUserReview_set) > 0) {
        while ($resultUserReview = mysqli_fetch_assoc($resultUserReview_set)) {
          // Generate the stars for rating
          $ratingStars = str_repeat('★', $resultUserReview['rating']) 
            . str_repeat('☆', 5 - $resultUserReview['rating']);
            ?>
            <div class="review-box">
              <div class="review-header">
                <strong><?php echo htmlspecialchars($resultUserReview['username']); ?></strong>
                <div class="review-rating">
                  <?php echo $ratingStars; ?>
                </div>
              </div>
              <div class="review-body">
                <p>
                  <?php echo htmlspecialchars($resultUserReview['review_text']); ?>
                </p>
              </div>
            </div>
            <?php
            }
          } else {
            echo '<p class = "no-review">No ratings and reviews available for this book.</p>';
          }
          db_disconnect($db);
          ?>
        </section>
        
  </main>
    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
  </body>
</html>