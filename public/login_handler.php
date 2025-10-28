<?php
// public/login_handler.php
// Process login POST: check method, CSRF, validate inputs, authenticate, redirect.

require_once __DIR__ . '/../includes/security.php';
require_once __DIR__ . '/../includes/validation.php';
require_once __DIR__ . '/../includes/auth.php';

// Only accept POST requests for login processing.
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('login.php');
}

// CSRF protection: invalid token -> redirect (die only when APP_DEBUG is true).
if (!csrf_validate()) {
    if (APP_DEBUG) {
        die('Invalid CSRF token');
    }
    redirect('login.php');
}

// Raw inputs (still untrusted):
$inputUsername = $_POST['username'] ?? null;
$inputPassword = $_POST['password'] ?? null;

// validate_login_inputs returns [bool $ok, mixed $dataOrErr].
[$ok, $dataOrErr] = validate_login_inputs($inputUsername, $inputPassword);

if (!$ok) {
    // Validation failed: store an error message in flash and show error view.
    $_SESSION['flash_error'] = $dataOrErr;
    redirect('login_error.php');
}

// Attempt authentication with validated data. On success redirect to home.
if (authenticate($dataOrErr['username'], $dataOrErr['password'])) {
    redirect('home.php');
}

// Authentication failed: set a generic error and show login error view.
$_SESSION['flash_error'] = 'Invalid username or password';
redirect('login_error.php');
