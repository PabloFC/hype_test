# PabloFuentes_HypeTest - PHP Login System

Authentication project in pure PHP with MySQL. Includes registration, login and user listing.

## Requirements

- PHP 8.1 or higher
- MySQL 5.7+ or MariaDB 10.4+
- Web server (Apache/Nginx)
- PDO MySQL extension enabled

## Installation

1. Copy this project to your server (example: `c:/laragon/www/PabloFuentes_HypeTest`)

2. Create the database:

```sql
CREATE DATABASE hype_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

3. Configure credentials in `config/config.php`:

   - DB_HOST
   - DB_PORT
   - DB_NAME
   - DB_USER
   - DB_PASS

- BASE_URL (example: `http://localhost/PabloFuentes_HypeTest/public`)

4. The users table is created automatically on first registration

## Usage

**Local development:**

- Open `http://localhost/PabloFuentes_HypeTest/public/` in your browser
- If using VirtualHost, configure DocumentRoot to `/public` folder

**Flow:**

1. Register at `/views/register.php`
2. Login at `/views/login.php`
3. You'll see the user list at `/views/home.php`

## Structure

```
/public     - Entry point and static assets (CSS, JS)
/views      - View templates (login, register, home, etc.)
/handlers   - Form handlers (login, register)
/includes   - PHP functions (DB, validation, security)
/config     - Configuration files
```

/views - Shared header and footer
/config - App configuration

````

## Security

The project includes:

- Password hashing with `password_hash()`
- Prepared statements to prevent SQL injection
- CSRF protection with tokens
- HTML escaping with `htmlspecialchars()`
- Secure sessions

## Notes

- For production, set `APP_DEBUG=false` in `config/config.php`
- Use HTTPS in production
- Configure `.htaccess` files to protect sensitive folders

## Database Table

```sql
CREATE TABLE users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(255) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
````
