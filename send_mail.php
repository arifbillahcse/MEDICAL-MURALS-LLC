<?php
header('Content-Type: application/json');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/vendor/autoload.php';

// Only accept POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed.']);
    exit;
}

// Sanitize & collect inputs
$firstName = htmlspecialchars(trim($_POST['firstName'] ?? ''));
$lastName  = htmlspecialchars(trim($_POST['lastName']  ?? ''));
$email     = filter_var(trim($_POST['email']   ?? ''), FILTER_SANITIZE_EMAIL);
$phone     = htmlspecialchars(trim($_POST['phone']     ?? 'Not provided'));
$product   = htmlspecialchars(trim($_POST['product']   ?? 'Not specified'));
$comment   = htmlspecialchars(trim($_POST['comment']   ?? ''));

// Validate required fields
if (!$firstName || !$lastName || !$email || !$comment) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in all required fields.']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please enter a valid email address.']);
    exit;
}

// ─────────────────────────────────────────────
//  SMTP CONFIGURATION — Hostinger
// ─────────────────────────────────────────────
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.hostinger.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@medicalmurals.com';
    $mail->Password   = 'YOUR_EMAIL_PASSWORD';   // <-- Replace with your Hostinger email password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port       = 465;

    // Sender & Recipient
    $mail->setFrom('info@medicalmurals.com', 'Medical Murals Website');
    $mail->addAddress('info@medicalmurals.com', 'Medical Murals LLC');
    $mail->addReplyTo($email, "$firstName $lastName");

    // Email content
    $mail->isHTML(true);
    $mail->Subject = "New Contact Form: $firstName $lastName";
    $mail->Body    = "
        <div style='font-family:Arial,sans-serif;max-width:600px;margin:0 auto;'>
            <div style='background:#0a1628;padding:24px 32px;border-radius:8px 8px 0 0;'>
                <h2 style='color:#e88a2e;margin:0;font-size:20px;'>New Contact Form Submission</h2>
                <p style='color:#8899bb;margin:6px 0 0;font-size:13px;'>Medical Murals LLC — Website Contact Form</p>
            </div>
            <table style='width:100%;border-collapse:collapse;font-size:15px;background:#fff;'>
                <tr>
                    <td style='padding:14px 20px;background:#f4f6f9;font-weight:700;color:#0a1628;width:150px;border-bottom:1px solid #eee;'>Name</td>
                    <td style='padding:14px 20px;border-bottom:1px solid #eee;'>$firstName $lastName</td>
                </tr>
                <tr>
                    <td style='padding:14px 20px;background:#f4f6f9;font-weight:700;color:#0a1628;border-bottom:1px solid #eee;'>Email</td>
                    <td style='padding:14px 20px;border-bottom:1px solid #eee;'><a href='mailto:$email' style='color:#e88a2e;'>$email</a></td>
                </tr>
                <tr>
                    <td style='padding:14px 20px;background:#f4f6f9;font-weight:700;color:#0a1628;border-bottom:1px solid #eee;'>Phone</td>
                    <td style='padding:14px 20px;border-bottom:1px solid #eee;'>$phone</td>
                </tr>
                <tr>
                    <td style='padding:14px 20px;background:#f4f6f9;font-weight:700;color:#0a1628;border-bottom:1px solid #eee;'>Product Interest</td>
                    <td style='padding:14px 20px;border-bottom:1px solid #eee;'>$product</td>
                </tr>
                <tr>
                    <td style='padding:14px 20px;background:#f4f6f9;font-weight:700;color:#0a1628;vertical-align:top;'>Message</td>
                    <td style='padding:14px 20px;line-height:1.7;'>$comment</td>
                </tr>
            </table>
            <div style='background:#f4f6f9;padding:16px 20px;border-radius:0 0 8px 8px;border-top:3px solid #e88a2e;'>
                <p style='color:#888;font-size:12px;margin:0;'>Sent from the contact form at medicalmurals.com</p>
            </div>
        </div>
    ";
    $mail->AltBody = "Name: $firstName $lastName\nEmail: $email\nPhone: $phone\nProduct: $product\nMessage: $comment";

    $mail->send();
    echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully!']);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Message could not be sent. Please email us at info@medicalmurals.com']);
}
