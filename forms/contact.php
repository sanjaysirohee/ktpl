<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/PHPMailer/Exception.php';
require __DIR__ . '/PHPMailer/PHPMailer.php';
require __DIR__ . '/PHPMailer/SMTP.php';

try {
    $name         = $_POST['name'] ?? '';
    $email        = $_POST['email'] ?? '';
    $phone        = $_POST['phoneno'] ?? '';
    $location     = $_POST['location'] ?? '';
    $requirements = $_POST['requirements'] ?? '';

    $isValidEmail = !empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL);

    // === 1️⃣ Send main mail to you ===
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = 'mail.veloxn.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'ragini.k@veloxn.com';
    $mail->Password   = 'kR.pwd@121';
    $mail->SMTPSecure = 'ssl'; // try 'tls' if this fails
    $mail->Port       = 465;   // try 587 for TLS

    // Fix SSL certificate issue
    $mail->SMTPOptions = [
        'ssl' => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        ]
    ];

    $mail->setFrom('ragini.k@veloxn.com', 'KTPL Website Contact Form');
    if ($isValidEmail) $mail->addReplyTo($email, $name);
    $mail->addAddress('ragini.k@veloxn.com', 'Ragini');

    $mail->isHTML(true);
    $mail->Subject = "New Contact Form Submission";
    $mail->Body = "
        <h3>New message from your website:</h3>
        <p><strong>Name:</strong> {$name}</p>
        <p><strong>Phone No:</strong> {$phone}</p>
        <p><strong>Location:</strong> {$location}</p>
        <p><strong>Requirements:</strong><br>" . nl2br(htmlspecialchars($requirements)) . "</p>
    ";

    $mail->send();

    // === 2️⃣ Send confirmation mail to user ===
    if ($isValidEmail) {
        $usermail = new PHPMailer(true);
        $usermail->isSMTP();
        $usermail->Host       = 'mail.veloxn.com';
        $usermail->SMTPAuth   = true;
        $usermail->Username   = 'ragini.k@veloxn.com';
        $usermail->Password   = 'kR.pwd@121';
        $usermail->SMTPSecure = 'ssl'; // same as above
        $usermail->Port       = 465;   // same as above

        $usermail->SMTPOptions = [
            'ssl' => [
                'verify_peer'       => false,
                'verify_peer_name'  => false,
                'allow_self_signed' => true
            ]
        ];

        $usermail->setFrom('ragini.k@veloxn.com', 'KTPL Technologies');
        $usermail->addAddress($email, $name);

        $usermail->isHTML(true);
        $usermail->Subject = 'We have received your message';
        $usermail->Body = "
            <p>Dear <b>{$name}</b>,</p>
            <p>Thank you for reaching out to <b>KTPL Technologies</b>. We’ve received your message and will get back to you soon.</p>
            <p><b>Your Location:</b><br>" . nl2br(htmlspecialchars($location)) . "</p>
            <p><b>Your Message:</b><br>" . nl2br(htmlspecialchars($requirements)) . "</p>
            <br><p>Best regards,<br><b>KTPL Technologies Team</b></p>
        ";

        try {
            $usermail->send();
        } catch (Exception $userError) {
            echo "<script>alert('⚠️ User email not sent: {$usermail->ErrorInfo}');</script>";
        }
    }

    echo "<script>alert('✔️ Message has been sent successfully!'); window.location.href='../index.html';</script>";

} catch (Exception $e) {
    echo "❌ Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
