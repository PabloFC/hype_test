<?php

declare(strict_types=1);
require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/session.php';
session_boot();
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= h(APP_NAME) ?></title>
  <link rel="stylesheet" href="<?= h(base_url('css/styles.css')) ?>?v=7.0">
</head>
<body>
<header class="site-header">
  <nav class="nav">
    <a class="brand" href="<?= h(base_url('index.php')) ?>"><?= h(APP_NAME) ?></a>
    <ul>
      <?php if (!empty($_SESSION['user_id'])): ?>
        <li>Hello, <?= h($_SESSION['username'] ?? 'user') ?></li>
        <li><a href="<?= h(base_url('home.php')) ?>">Home</a></li>
        <li><a href="<?= h(base_url('logout.php')) ?>">Logout</a></li>
      <?php else: ?>
        <li><a href="<?= h(base_url('login.php')) ?>">Login</a></li>
        <li><a href="<?= h(base_url('register.php')) ?>">Sign Up</a></li>
      <?php endif; ?>
    </ul>
  </nav>
</header>
<main class="container">
