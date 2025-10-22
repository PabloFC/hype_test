<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/config.php';

// Starts session with secure cookie settings if not already active
function session_boot(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_name(SESSION_NAME);
        $secure = COOKIE_SECURE;
        $httponly = COOKIE_HTTPONLY;
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => $secure,
            'httponly' => $httponly,
            'samesite' => COOKIE_SAMESITE,
        ]);
        session_start();
    }
}

// Regenerates session ID to prevent session fixation attacks
function session_regenerate(): void {
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
    }
}
