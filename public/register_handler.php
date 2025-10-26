<?php
require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('register.php');
}

if (!csrf_validate()) {
    if (APP_DEBUG) {
        die('Invalid CSRF token');
    }
    redirect('register.php');
}

[$okUser, $usernameOrErr] = validate_username($_POST['username'] ?? null);
[$okEmail, $emailOrErr] = validate_email($_POST['email'] ?? null);
[$okPass, $passOrErr] = validate_passwords($_POST['password'] ?? null, $_POST['confirm_password'] ?? null);

if (!$okUser || !$okEmail || !$okPass) {
    if (!$okUser) {
        $_SESSION['flash_error'] = $usernameOrErr;
    } elseif (!$okEmail) {
        $_SESSION['flash_error'] = $emailOrErr;
    } else {
        $_SESSION['flash_error'] = $passOrErr;
    }
    redirect('views/register.php');
}
[$ok, $message] = register_user((string)$usernameOrErr, (string)$emailOrErr, (string)$passOrErr);
if ($ok) {
    // Auto-login after successful registration
    authenticate((string)$usernameOrErr, (string)$passOrErr);
    // Set a flash success message so the user receives feedback after redirect
    $_SESSION['flash_success'] = 'Registration successful. Welcome, ' . (string)$usernameOrErr . '!';
    redirect('home.php');
}
$_SESSION['flash_error'] = $message;
redirect('register.php');
