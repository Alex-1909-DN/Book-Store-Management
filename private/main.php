
<?php
// Include database connection
require_once('database.php');

// Connect to the database
$db = db_connect();

// $id = $_GET[id];
// Initialize variables
$search_query = '';
$selected_category = 'all';  // Default category filter
$selected_topics = [];  // Default topics filter
$books = [];

// Handle search and category filter functionality
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // If a search query is provided, capture it
    if (isset($_GET['query']) && !empty($_GET['query'])) {
        $search_query = mysqli_real_escape_string($db, $_GET['query']);
    }
    
    // If a category filter is provided, capture it
    if (isset($_GET['category']) && !empty($_GET['category']) && $_GET['category'] != 'all') {
        $selected_category = mysqli_real_escape_string($db, $_GET['category']);
    }

    // Construct SQL query based on search query and category filter
    $sql = "SELECT books.*, categories.name AS category_name 
            FROM books 
            LEFT JOIN categories ON books.category_id = categories.id 
            WHERE (books.title LIKE '%$search_query%' 
            OR books.author LIKE '%$search_query%' 
            OR categories.name LIKE '%$search_query%')";

    // Apply category filter if it's not "all"
    if ($selected_category != 'all') {
        $sql .= " AND books.category_id = '$selected_category'";
    }
    
    $sql .= " ORDER BY books.title ASC";  // Sorting books by title
    
    $result_set = mysqli_query($db, $sql);

    // Fetch results if query is successful
    if ($result_set) {
        while ($book = mysqli_fetch_assoc($result_set)) {
            $books[] = $book;
        }
        mysqli_free_result($result_set);
    }
}

// Handle recommendations based on topics
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['topic'])) {
    $selected_topics = $_POST['topic'];
    $topic_filter = implode("','", array_map('mysqli_real_escape_string', array_fill(0, count($selected_topics), $db), $selected_topics));  // Format the topics for SQL query

    // Construct SQL query based on selected topics
    $sql = "SELECT books.*, categories.name AS category_name 
            FROM books 
            LEFT JOIN categories ON books.category_id = categories.id 
            WHERE categories.name IN ('$topic_filter') 
            ORDER BY books.title ASC";
    
    $result_set = mysqli_query($db, $sql);

    // Fetch results if query is successful
    if ($result_set) {
        while ($book = mysqli_fetch_assoc($result_set)) {
            $books[] = $book;
        }
        mysqli_free_result($result_set);
    }
}
?>

<!-- All the cover of the books are saved the link of the book in database, and the images are saved in a seperate folder - images -->

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
        name="description"
        content="This page provides functionality for searching, filtering books by categories, viewing recommendations, and managing book entries (view, update, delete). The page includes dynamic book listings and search filters."
    />
    <meta
        name="keywords"
        content="Bookstore, book, title, author, category, search"
    />
    <title>Bookstore Main Page</title>
    <link rel="stylesheet" href="../public/stylesheet/styles.css" />
    </head>
    <body>
    <!-- Navigation Bar -->
    <?php include 'header.php'; ?>

    <!-- Main Content Section -->
    <main>
        <div class="main-container">
            <!-- Search Bar Section -->
            <section class="search-section">
                <form method="GET" action="main.php" class="search-form">
                    <!-- Search Bar -->
                    <input 
                        type="text" 
                        name="query" 
                        placeholder="Search by Title, Author, Genre" 
                        class="search-bar" 
                        value="<?php echo htmlspecialchars($search_query); ?>" 
                    />
                    
                    <!-- Category Dropdown -->
                    <div class="category-dropdown">
                        <select name="category" id="categoryFilter">
                            <option value="all" <?php echo $selected_category == 'all' ? 'selected' : ''; ?>>All Categories</option>
                            <?php
                            // Fetch categories from the database
                            $category_result = mysqli_query($db, "SELECT id, name FROM categories");
                            while ($category = mysqli_fetch_assoc($category_result)) {
                                echo '<option value="' . htmlspecialchars($category['id']) . '"';
                                if ($selected_category == $category['id']) {
                                    echo ' selected';
                                }
                                echo '>' . htmlspecialchars($category['name']) . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <button type="submit" class="search-button">Search</button>
                </form>
            </section>

            <!-- Book Recommendations Section -->
            <div class="newbook">
                <h2>Want to add new book?</h2>
                <a href="addNewBook.php"><button type="submit">Add new book</button></a>
            </div>

            <!-- Book Listings Section -->
            <div class="booklist-container">
                <section class="book-list">
                    <?php if (!empty($books)): ?>
                        <?php foreach ($books as $book): ?>
                            <div class="book-item" data-id="<?php echo $book['id']; ?>">
                                <!-- Wrap the image with an anchor tag linking to detail.php -->
                            <a href="detail.php?id=<?php echo $book['id']; ?>">
                                <img src="<?php echo htmlspecialchars($book['path_name']); ?>" 
                                alt="<?php echo htmlspecialchars($book['alt_text']); ?>" />
                            </a>
                                <h3><?php echo htmlspecialchars($book['title']); ?></h3>
                                <p>Author: <?php echo htmlspecialchars($book['author']); ?></p>
                                <p>Category: <?php echo htmlspecialchars($book['category_name']); ?></p>
                                <div class="book-actions">
                                    <a href="delete.php?id=<?php echo $book['id']; ?>"><button class="action-button">Delete</button></a>
                                    <a href="update.php?id=<?php echo $book['id']; ?>"><button class="action-button">Update</button></a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No books found.</p>
                    <?php endif; ?>
                </section>  
            </div>
        </div>
    </main>

    <!-- Footer Section -->
    <?php include 'footer.php'; ?>
</body>
</html>

<?php
// Close the database connection
db_disconnect($db);
?>