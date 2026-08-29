<?php
/**
 * Shared Helper & Utility Functions
 * UnityDesignX Platform
 */

require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

/**
 * Get Database Connection Instance
 */
function get_db(): PDO {
    return Database::getInstance();
}

/**
 * Safe HTML Escaping (Prevents XSS)
 */
function e(?string $string): string {
    return htmlspecialchars($string ?? '', ENT_QUOTES, 'UTF-8');
}

/**
 * Format Currency Amount
 */
function format_price($amount): string {
    return '₹' . number_format((float)$amount, 2);
}

/**
 * Return Standardized JSON API Response
 */
function json_response(array $data, int $statusCode = 200): void {
    http_response_code($statusCode);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    exit;
}

/**
 * Generate CSRF Token
 */
function generate_csrf_token(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF Token
 */
function verify_csrf_token(?string $token): bool {
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Check if User is Logged In
 */
function is_logged_in(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

/**
 * Get Current Logged In User Data
 */
function current_user(): ?array {
    if (!is_logged_in()) {
        return null;
    }
    return $_SESSION['user'] ?? null;
}

/**
 * Check if Current User has Admin Role
 */
function is_admin(): bool {
    $user = current_user();
    return $user !== null && ($user['role_name'] === 'admin' || (int)$user['role_id'] === 1);
}

/**
 * Middleware: Require Authentication
 */
function require_login(): void {
    if (!is_logged_in()) {
        if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            json_response(['success' => false, 'error' => 'Authentication required'], 401);
        } else {
            header('Location: ' . APP_URL . '/public/login.php');
            exit;
        }
    }
}

/**
 * Middleware: Require Admin Privilege (Masks Admin pages with 404 for unauthorized users)
 */
function require_admin(): void {
    if (!is_logged_in() || !is_admin()) {
        http_response_code(404);
        if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
            json_response(['success' => false, 'error' => 'Page not found'], 404);
        } else {
            echo '<!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <title>404 Not Found</title>
                <style>
                    body { background: #0b0d11; color: #f3f4f6; font-family: sans-serif; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; text-align: center; }
                    h1 { font-size: 4rem; color: #d4af37; margin: 0 0 1rem; }
                    p { color: #9ca3af; font-size: 1.1rem; margin-bottom: 2rem; }
                    a { color: #d4af37; text-decoration: none; border: 1px solid #d4af37; padding: 0.75rem 1.5rem; border-radius: 8px; font-weight: 600; }
                    a:hover { background: #d4af37; color: #000; }
                </style>
            </head>
            <body>
                <div>
                    <h1>404</h1>
                    <p>The requested URL was not found on this server.</p>
                    <a href="' . APP_URL . '/public/index.php">Return to Home</a>
                </div>
            </body>
            </html>';
            exit;
        }
    }
}

/**
 * Sanitize User Text Input
 */
function sanitize_input(?string $data): string {
    return trim($data ?? '');
}

/**
 * Get User Cart Item Count
 */
function get_cart_count(): int {
    if (!is_logged_in()) {
        return 0;
    }
    $db = get_db();
    $userId = $_SESSION['user_id'];
    
    $stmt = $db->prepare("
        SELECT SUM(ci.quantity) AS total_items
        FROM cart c
        JOIN cart_items ci ON c.cart_id = ci.cart_id
        WHERE c.user_id = :user_id
    ");
    $stmt->execute([':user_id' => $userId]);
    $row = $stmt->fetch();
    return (int)($row['total_items'] ?? 0);
}

/**
 * Send Email Notification
 */
function send_email_notification(string $to, string $subject, string $messageBody, ?string $replyTo = null): bool {
    if (!defined('ENABLE_EMAIL_NOTIFICATIONS') || !ENABLE_EMAIL_NOTIFICATIONS) {
        return false;
    }

    $headers = [];
    $headers[] = 'MIME-Version: 1.0';
    $headers[] = 'Content-type: text/html; charset=utf-8';
    $headers[] = 'From: ' . APP_NAME . ' <' . (defined('SMTP_FROM') ? SMTP_FROM : 'noreply@unitydesign.com') . '>';
    if ($replyTo) {
        $headers[] = 'Reply-To: ' . $replyTo;
    }
    $headers[] = 'X-Mailer: PHP/' . phpversion();

    // Standard PHP mail() attempt (works with local sendmail/smtp relay or live hosting)
    @$sent = mail($to, $subject, $messageBody, implode("\r\n", $headers));
    
    // Log email dispatch attempt
    error_log("Email notification dispatch to [{$to}] | Subject: [{$subject}] | Status: " . ($sent ? "SUCCESS" : "LOGGED (Requires active SMTP/Sendmail)"));

    return $sent;
}
