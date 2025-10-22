<?php

declare(strict_types=1);

require_once __DIR__ . '/session.php';
require_once __DIR__ . '/../config/config.php';

// Escapes HTML special characters to prevent XSS attacks
function h(?string $value): string {
    return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function base_url(string $path = ''): string {
    $base = rtrim(BASE_URL, '/');
    $path = ltrim($path, '/');
    return $path ? $base . '/' . $path : $base;
}

// Generates or retrieves CSRF token from session for form protection
function csrf_token(): string {
    session_boot();
    if (empty($_SESSION[CSRF_TOKEN_KEY])) {
        $_SESSION[CSRF_TOKEN_KEY] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_TOKEN_KEY];
}

function csrf_field(): string {
    $token = csrf_token();
    return '<input type="hidden" name="csrf_token" value="' . h($token) . '">';
}

// Validates CSRF token using timing-safe comparison to prevent attacks
function csrf_validate(): bool {
    session_boot();
    $token = $_POST['csrf_token'] ?? '';
    $valid = is_string($token) && hash_equals($_SESSION[CSRF_TOKEN_KEY] ?? '', $token);
    return $valid;
}

function redirect(string $path): never {
    header('Location: ' . base_url($path));
    exit;
}
