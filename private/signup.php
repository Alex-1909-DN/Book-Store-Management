
<?php
session_start();
// Check if there is an error message stored in the session
if (isset($_SESSION['error_message'])) {
    $error_message = $_SESSION['error_message'];
    unset($_SESSION['error_message']); 
}
?>



<!DOCTYPE html>
<html lang="en">
  <!-- Meta tags for character encoding and responsive design -->
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta
        name="description"
        content="This page includes a form for new user registration with fields for name, email, username, password, and password confirmation. If there are any error messages from a previous attempt, they are displayed at the top of the form."
    />
    <meta
        name="keywords"
        content="Bookstore, book, name, email, username, password, signup"
    />
    <!-- Page title -->
    <title>Bookstore Sign Up Page</title>

    <!-- Link to external stylesheet -->
    <link rel="stylesheet" href="../public/stylesheet/styles.css" />
    <!-- Link to external JavaScript file-->
    <script src="../public/scripts/javascript_signup.js" defer></script>
  </head>
  <body>
    <!-- Main container for the sign-up page -->
    <div class="container-signup">
      <div class="welcome-signup">
        <h1>Welcome to Bookstore</h1>
      </div>
      <div class="signup-detail">
        <!-- Left Section with Background Image -->
        <div class="left-section-signup">
          <div class="image-signup"></div>
          <img src="../public/images/image9.jpg" alt="image of book" />
        </div>

        <!-- Right Section with Sign-Up Form -->
        <div class="right-section-signup">
          <!-- Display error message if it exists -->
          <?php if (isset($error_message)): ?>
            <div class="warning">
              <?php echo $error_message; ?>
            </div>
          <?php endif; ?>

          <!-- Sign-up form for new user registration -->
          <form action="createNewUser.php" method="POST" onsubmit="return validate();" >
            <!-- Name input field -->
            <label for="name">Name</label>
            <input
              type="text"
              id="name"
              name="name"
              placeholder="Enter your name"
            />

            <!-- Email input field -->
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              name="email"
              placeholder="Enter your email"
            />

            <!-- Username input field -->
            <label for="username">Username</label>
            <input
              type="text"
              id="username"
              name="username"
              placeholder="Choose your username"
            />

            <!-- Password input field -->
            <label for="password">Password</label>
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Create your password"
            />

            <!-- Confirm Password input field -->
            <label for="confirm-password">Confirm Password</label>
            <input
              type="password"
              id="confirm-password"
              name="confirm-password"
              placeholder="Confirm your password"
            />

            <!-- Submit button -->
            <button class="button" type="submit">Sign up</button>
            <p class="signin-link">
              Already have an account?
              <a href="../public/index.php">Sign in</a>.
            </p>
          </form>
        </div>
      </div>
    </div>
  </body>
</html>
