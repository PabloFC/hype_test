<?php
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/session.php';
session_boot();
?>
<section class="card">
  <h2>Login</h2>
  <form id="form-login" action="<?= h(base_url('login_handler.php')) ?>" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" required>
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" required>
    </div>
    <button class="btn primary" type="submit">Login</button>
  </form>
</section>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
