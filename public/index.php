
<?php
session_start();

// Retrieve and clear error messages for username and password
$username_error = $_SESSION['username_error'] ?? null;
$password_error = $_SESSION['password_error'] ?? null;

unset($_SESSION['username_error']);
unset($_SESSION['password_error']);
?>



<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta
        name="description"
        content="This page includes a form to input a username and password, with validation before submission. The page also offers a link for new users to register."
    />
    <meta
        name="keywords"
        content="Bookstore, book, signin, username, password"
    />
  <title>Bookstore Sign In Page</title>
  <link rel="stylesheet" href="stylesheet/styles.css">
  <script src="scripts/javascript_index.js" defer></script>
</head>
<body>
  <div class="container">
    <div class="welcome">
      <h2>Welcome to Bookstore</h2>
    </div>
    <div class="detail-container">
      <div class="left-section">
        <p>Welcome to our online bookstore, your one-stop destination for all kinds of books!</p>
        <p>Discover a wide range of genres, from timeless classics to the latest releases in fiction and non-fiction.</p>
        <p>Sign in now to explore personalized recommendations, and much more!</p>  
      </div>
      <div class="right-section">
        <form action="../private/login.php" method="POST" onsubmit="return validate();">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter your username" required>
          <!-- Display error for username -->
          <?php if ($username_error): ?>
            <p class="warning"><?php echo htmlspecialchars($username_error); ?></p>
          <?php endif; ?>

          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required>
          <!-- Display error for password -->
          <?php if ($password_error): ?>
            <p class="warning"><?php echo htmlspecialchars($password_error); ?></p>
          <?php endif; ?>

          <button class="button" type="submit">Sign in</button>
          <p class="register-link">
            Don’t have an account? <a href="/Assignment2/private/signup.php">Register here</a>.
          </p>
        </form>
      </div>
    </div>
  </div>
</body>
</html>