<?php
// public/register_handler.php
// Process registration POST: check method & CSRF, validate inputs, create user, auto-login.

require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../includes/auth.php';

// Only accept POST requests.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('register.php');
}

// CSRF protection: die in debug mode, otherwise redirect.
if (!csrf_validate()) {
    if (APP_DEBUG) {
        die('Invalid CSRF token');
    }
    redirect('register.php');
}

// Validate username, email and password pair. Each validator returns [bool, valueOrError].
[$okUser, $usernameOrErr] = validate_username($_POST['username'] ?? null);
[$okEmail, $emailOrErr] = validate_email($_POST['email'] ?? null);
[$okPass, $passOrErr] = validate_passwords($_POST['password'] ?? null, $_POST['confirm_password'] ?? null);

if (!$okUser || !$okEmail || !$okPass) {
    // Pick the first failing validation message to show as flash.
    if (!$okUser) {
        $_SESSION['flash_error'] = $usernameOrErr;
    } elseif (!$okEmail) {
        $_SESSION['flash_error'] = $emailOrErr;
    } else {
        $_SESSION['flash_error'] = $passOrErr;
    }
    redirect('views/register.php');
}

// Create the user. register_user returns [bool $ok, string $message].
[$ok, $message] = register_user((string)$usernameOrErr, (string)$emailOrErr, (string)$passOrErr);
if ($ok) {
    // On success: auto-login and send a flash success message.
    authenticate((string)$usernameOrErr, (string)$passOrErr);
    $_SESSION['flash_success'] = 'Registration successful. Welcome, ' . (string)$usernameOrErr . '!';
    redirect('home.php');
}

// Failure creating user: show the error message returned by register_user().
$_SESSION['flash_error'] = $message;
redirect('register.php');
