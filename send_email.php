<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';  // Include the PHPMailer autoloader

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    // Validate and sanitize the form data
    $firstName = htmlspecialchars(stripslashes(trim($firstName)));
    $lastName = htmlspecialchars(stripslashes(trim($lastName)));
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(stripslashes(trim($subject)));
    $phone = htmlspecialchars(stripslashes(trim($phone)));
    $message = htmlspecialchars(stripslashes(trim($message)));

    // Check if email is valid
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Set up PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();  // Use SMTP
            $mail->Host = 'smtp.gmail.com';  // Set the SMTP server to Gmail
            $mail->SMTPAuth = true;  // Enable SMTP authentication
            $mail->Username = 'hero.alshaqsi@gmail.com';  // Your Gmail email address
            $mail->Password = 'ijdc wjaf opcd zgyb';  // Your Gmail app password (use 2FA if required)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  // Use TLS encryption
            $mail->Port = 587;  // TCP port for TLS

            // Recipients
            $mail->setFrom($email, $firstName . ' ' . $lastName);  // Sender's email
            $mail->addAddress('hero.alshaqsi@gmail.com');  // Recipient's email

            // Content
            $mail->isHTML(true);  // Set email format to HTML
            $mail->Subject = $subject;
            $mail->Body = "
            <html>
            <head>
                <title>$subject</title>
            </head>
            <body>
                <p><strong>Name:</strong> $firstName $lastName</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Phone:</strong> $phone</p>
                <p><strong>Message:</strong></p>
                <p>$message</p>
            </body>
            </html>
            ";

            // Send email
            $mail->send();
            echo 'Your message has been sent successfully.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Invalid email address.";
    }
}
?>
