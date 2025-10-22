<?php
require_once __DIR__ . '/../views/header.php';
?>
<section>
  <h1>Welcome</h1>
  <p>This is a sample project in pure PHP with authentication.</p>
  <p>
    <a class="btn" href="<?= h(base_url('register.php')) ?>">Create Account</a>
    <a class="btn" href="<?= h(base_url('login.php')) ?>">Login</a>
  </p>
</section>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
