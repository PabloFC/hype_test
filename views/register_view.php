<?php
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/session.php';
session_boot();
?>
<section class="card">
  <h2>Sign Up</h2>
  <form id="form-register" action="<?= h(base_url('register_handler.php')) ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
      <small>Must include uppercase, lowercase and numbers (min 8 characters).</small>
    </div>
    <div class="form-group">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="form-group">
      <label for="email">Email Address</label>
      <input type="email" id="email" name="email" required>
    </div>
    <button class="btn primary" type="submit">Register</button>
  </form>
</section>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
