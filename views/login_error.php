
<?php
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../includes/session.php';
session_boot();
?>
<section class="card error">
  <h2>Login Error</h2>
  <p>
    <?php
    if (!empty($_SESSION['flash_error'])) {
      echo h($_SESSION['flash_error']);
      unset($_SESSION['flash_error']);
    } else {
      echo 'Your username or password is incorrect. Please try again.';
    }
    ?>
  </p>
  <a class="btn" href="login.php">Back to login</a>
</section>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
