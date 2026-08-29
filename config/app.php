<?php
/**
 * Global Application Configuration Constants
 * UnityDesignX Platform
 */

// Application Constants
define('APP_NAME', 'UnityDesignX');
define('APP_TAGLINE', 'The Art of Fine Living');
define('APP_URL', 'http://localhost/InteriorDesign');
define('APP_DEBUG', true);

// Database Connection Settings
define('DB_HOST', 'localhost');
define('DB_PORT', '3307');
define('DB_NAME', 'unity');
define('DB_USER', 'root');
define('DB_PASS', '');

// Email Notification Settings
define('ADMIN_EMAIL', 'admin@unitydesign.com'); // Destination email for contact form messages
define('SMTP_HOST', 'smtp.gmail.com');          // Your SMTP Host (e.g. smtp.gmail.com)
define('SMTP_PORT', 587);                        // SMTP Port (587 for TLS, 465 for SSL)
define('SMTP_USER', '');                         // Your SMTP Username / Email
define('SMTP_PASS', '');                         // Your SMTP Password / App Password
define('SMTP_FROM', 'noreply@unitydesign.com');   // From Email Address
define('ENABLE_EMAIL_NOTIFICATIONS', true);      // Enable/Disable sending emails

// Directory Paths
define('ROOT_PATH', dirname(__DIR__));
define('PUBLIC_PATH', ROOT_PATH . '/public');
define('INCLUDES_PATH', ROOT_PATH . '/includes');
define('ASSETS_PATH', ROOT_PATH . '/assets');
define('UPLOADS_PATH', ROOT_PATH . '/assets/images/uploads');

// Start Secure Session if not active
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.cookie_httponly', '1');
    ini_set('session.use_only_cookies', '1');
    session_start();
}
