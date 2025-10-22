<?php
require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('login.php');
}

if (!csrf_validate()) {
    if (APP_DEBUG) {
        die('Invalid CSRF token');
    }
    redirect('login.php');
}

[$ok, $dataOrErr] = validate_login_inputs($_POST['username'] ?? null, $_POST['password'] ?? null);

if (!$ok) {
    $_SESSION['flash_error'] = $dataOrErr;
    redirect('login_error.php');
}

if (authenticate($dataOrErr['username'], $dataOrErr['password'])) {
    redirect('home.php');
}
$_SESSION['flash_error'] = 'Invalid username or password';
redirect('login_error.php');
