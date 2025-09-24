<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';

$mail = new PHPMailer(true);

try {
    $name     = $_POST['name'] ?? '';
    $email    = $_POST['email'] ?? '';
    $phone    = $_POST['phoneno'] ?? '';
    $companyname    = $_POST['companyname'] ?? '';
    $location    = $_POST['location'] ?? '';
    $service    = $_POST['service'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $quantity  = $_POST['quantity'] ?? '';
    $requirements  = $_POST['requirements'] ?? '';

    // SMTP settings
    $mail->isSMTP();
    $mail->Host       = 'mail.veloxn.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ragini.k@veloxn.com';
    $mail->Password   = 'kR.pwd@121';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    // Sender and recipient
    $mail->setFrom('ragini.k@veloxn.com', 'KTPL Website Contact Form');
    $mail->addAddress('ragini.k@veloxn.com', 'Ragini');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = "New Contact Form Submission";
    $mail->Body    = "
        <h3>New message from your website:</h3>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Email:</strong> {$email}</p>
        <p><strong>Phone No:</strong> {$phone}</p>
        <p><strong>Company Name:</strong> {$companyname}</p>
        <p><strong>Location:</strong> {$location}</p>
        <p><strong>Service:</strong> {$service}</p>
        <p><strong>Duration:</strong> {$duration}</p>
        <p><strong>Quantity:</strong> {$quantity}</p>
        <p><strong>Requirements:</strong><br>" . nl2br($requirements) . "</p>
    ";

    $mail->send();
    echo "OK"; // validate.js expects 'OK' for success

} catch (Exception $e) {
    echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
