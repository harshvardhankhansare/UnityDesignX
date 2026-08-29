<?php
/**
 * API: Submit Contact Message
 * POST /api/contact.php
 * UnityDesignX Platform
 */

require_once __DIR__ . '/../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Method not allowed.'], 405);
}

// Read input (JSON or Form POST)
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$name    = sanitize_input($input['name'] ?? '');
$email   = sanitize_input($input['email'] ?? '');
$subject = sanitize_input($input['subject'] ?? 'General Inquiry');
$message = sanitize_input($input['message'] ?? '');

// Validation
if (!$name || !$email || !$message) {
    json_response(['success' => false, 'error' => 'Name, Email, and Message are required fields.'], 422);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(['success' => false, 'error' => 'Please provide a valid email address.'], 422);
}

$db = get_db();

try {
    $stmt = $db->prepare("
        INSERT INTO contact_messages (name, email, subject, message, created_at)
        VALUES (:name, :email, :subject, :message, NOW())
    ");
    $stmt->execute([
        ':name'    => $name,
        ':email'   => $email,
        ':subject' => $subject,
        ':message' => $message
    ]);

    // 2. Dispatch HTML Email Notification to Admin Destination
    $emailSubject = "New Contact Inquiry: " . $subject;
    $htmlBody = "
    <html>
    <head>
      <style>
        body { font-family: Arial, sans-serif; background: #0f1115; color: #f3f4f6; padding: 20px; }
        .card { background: #161920; border: 1px solid #d4af37; border-radius: 8px; padding: 24px; max-width: 600px; margin: 0 auto; }
        .header { font-size: 20px; font-weight: bold; color: #d4af37; margin-bottom: 16px; }
        .field { margin-bottom: 12px; }
        .label { font-size: 12px; text-transform: uppercase; color: #9ca3af; font-weight: bold; }
        .val { font-size: 15px; color: #ffffff; margin-top: 4px; }
        .msg-box { background: #0d0f12; padding: 16px; border-radius: 6px; border-left: 4px solid #d4af37; margin-top: 16px; }
      </style>
    </head>
    <body>
      <div class='card'>
        <div class='header'>📩 New Website Contact Inquiry</div>
        <div class='field'><div class='label'>Sender Name</div><div class='val'>" . e($name) . "</div></div>
        <div class='field'><div class='label'>Sender Email</div><div class='val'>" . e($email) . "</div></div>
        <div class='field'><div class='label'>Subject</div><div class='val'>" . e($subject) . "</div></div>
        <div class='field'><div class='label'>Received At</div><div class='val'>" . date('Y-m-d H:i:s') . "</div></div>
        <div class='msg-box'>
          <div class='label'>Message Content</div>
          <div class='val'>" . nl2br(e($message)) . "</div>
        </div>
      </div>
    </body>
    </html>";

    send_email_notification(ADMIN_EMAIL, $emailSubject, $htmlBody, $email);

    json_response([
        'success' => true,
        'message' => 'Thank you! Your message has been sent successfully to ' . ADMIN_EMAIL . '.'
    ]);
} catch (PDOException $e) {
    error_log('Contact API error: ' . $e->getMessage());
    json_response(['success' => false, 'error' => 'Unable to save message. Please try again.'], 500);
}
