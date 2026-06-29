<?php
// TEMPORARY TEST FILE - DELETE AFTER TESTING
$to      = 'info@medicalmurals.com';
$subject = 'Test Email from Medical Murals Website';
$message = 'This is a test email to confirm PHP mail() is working on Hostinger.';
$headers = 'From: info@medicalmurals.com' . "\r\n" . 'Reply-To: info@medicalmurals.com';

if (mail($to, $subject, $message, $headers)) {
    echo '<h2 style="color:green;">✓ mail() works! Check your inbox at info@medicalmurals.com</h2>';
} else {
    echo '<h2 style="color:red;">✗ mail() failed. PHP mail() is not enabled on this server.</h2>';
}
?>
