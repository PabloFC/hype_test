<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../views/header.php';
require_once __DIR__ . '/../includes/security.php';

if (!is_authenticated()) {
  redirect('login.php');
}
$users = get_all_users();
?>
<section>
  <h2>Registered Users</h2>
  <div class="table-responsive">
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Username</th>
          <th>Email</th>
          <th>Registered</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td data-label="ID"><?= h((string)$u['id']) ?></td>
          <td data-label="Username"><?= h($u['username']) ?></td>
          <td data-label="Email"><?= h($u['email']) ?></td>
          <td data-label="Registered"><?= h($u['created_at']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</section>
<?php require_once __DIR__ . '/../views/footer.php'; ?>
