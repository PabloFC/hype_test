<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/session.php';

// Creates users table if it doesn't exist
function ensure_users_table(): void {
    $pdo = db_get_connection();
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS users (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            username VARCHAR(50) NOT NULL UNIQUE,
            email VARCHAR(255) NOT NULL UNIQUE,
            password_hash VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;'
    );
}

function user_exists(string $username, string $email): array {
    $pdo = db_get_connection();
    $stmt = $pdo->prepare('SELECT username, email FROM users WHERE username = :u OR email = :e LIMIT 1');
    $stmt->execute([':u' => $username, ':e' => $email]);
    $row = $stmt->fetch();
    return [
        'username' => $row && $row['username'] === $username,
        'email' => $row && $row['email'] === $email,
    ];
}

function register_user(string $username, string $email, string $password): array {
    ensure_users_table();
    $exists = user_exists($username, $email);
    if ($exists['username']) return [false, 'Username is already registered'];
    if ($exists['email']) return [false, 'Email is already registered'];

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $pdo = db_get_connection();
    $stmt = $pdo->prepare('INSERT INTO users (username, email, password_hash) VALUES (:u, :e, :p)');
    try {
        $stmt->execute([':u' => $username, ':e' => $email, ':p' => $hash]);
        return [true, 'User registered successfully'];
    } catch (PDOException $e) {
        if (APP_DEBUG) throw $e;
        return [false, 'Could not register user'];
    }
}

function authenticate(string $username, string $password): bool {
    ensure_users_table();
    $pdo = db_get_connection();
    $stmt = $pdo->prepare('SELECT id, username, password_hash FROM users WHERE username = :u LIMIT 1');
    $stmt->execute([':u' => $username]);
    $user = $stmt->fetch();
    if (!$user) return false;
    if (!password_verify($password, $user['password_hash'])) return false;
    // Rehash password if algorithm has been updated for better security
    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $upd = $pdo->prepare('UPDATE users SET password_hash = :p WHERE id = :id');
        $upd->execute([':p' => $newHash, ':id' => $user['id']]);
    }
    session_boot();
    $_SESSION['user_id'] = (int)$user['id'];
    $_SESSION['username'] = $user['username'];
    session_regenerate();
    return true;
}

function is_authenticated(): bool {
    session_boot();
    return isset($_SESSION['user_id']);
}

// Destroys session completely and removes session cookie
function logout(): void {
    session_boot();
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}

function get_all_users(): array {
    $pdo = db_get_connection();
    $stmt = $pdo->query('SELECT id, username, email, created_at FROM users ORDER BY created_at DESC');
    return $stmt->fetchAll();
}
