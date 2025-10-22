<?php

declare(strict_types=1);

function sanitize_string(string $value): string {
    $value = trim($value);
    $value = preg_replace('/\s+/', ' ', $value);
    return $value;
}

function validate_username(?string $username): array {
    $username = sanitize_string((string)$username);
    if ($username === '') return [false, 'Username is required'];
    if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $username)) return [false, 'Username must be 3-20 alphanumeric characters or _'];
    return [true, $username];
}

function validate_email(?string $email): array {
    $email = sanitize_string((string)$email);
    if ($email === '') return [false, 'Email is required'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return [false, 'Email is not valid'];
    return [true, $email];
}

function validate_passwords(?string $pass, ?string $confirm): array {
    $pass = (string)$pass;
    $confirm = (string)$confirm;
    if ($pass === '' || $confirm === '') return [false, 'Password and confirmation are required'];
    if (strlen($pass) < 8) return [false, 'Password must be at least 8 characters'];
    if (!preg_match('/[A-Z]/', $pass) || !preg_match('/[a-z]/', $pass) || !preg_match('/[0-9]/', $pass)) {
        return [false, 'Password must include uppercase, lowercase and numbers'];
    }
    if (!hash_equals($pass, $confirm)) return [false, 'Passwords do not match'];
    return [true, $pass];
}

function validate_login_inputs(?string $username, ?string $password): array {
    [$okUser, $valUser] = validate_username($username);
    if (!$okUser) return [false, $valUser];
    $password = (string)$password;
    if ($password === '') return [false, 'Password is required'];
    return [true, ['username' => $valUser, 'password' => $password]];
}
