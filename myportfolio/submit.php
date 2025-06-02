<?php


require __DIR__ . '/../vendor/autoload.php';
// Ensure you have PHPMailer installed via Composer

use Dotenv\Dotenv;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? strip_tags(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL) : '';
    $message = isset($_POST['message']) ? strip_tags(trim($_POST['message'])) : '';

    if (empty($name) || empty($email) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo "Please fill in all fields correctly.";
        exit;
    }

    // Load environment variables
    $dotenv = Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $_ENV['SMTP_USERNAME'];
        $mail->Password = $_ENV['SMTP_PASSWORD'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Recipients
        $mail->setFrom($mail->Username, 'Website Contact Form');
        $mail->addAddress('jepkemoi75@gmail.com'); // Your receiving email

        // Content
        $mail->Subject = "New Contact Form Submission from $name";
        $mail->Body = "You have received a new message from your website contact form:\n\n"
                    . "Name: $name\n"
                    . "Email: $email\n"
                    . "Message:\n$message\n";
        $mail->AltBody = $mail->Body;

        $mail->send();

        http_response_code(200);
        header("Location: thank_you.html");
        exit();

    } catch (Exception $e) {
        http_response_code(500);
        echo "Sorry, something went wrong. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    http_response_code(403);
    echo "There was a problem with your submission. Please try again.";
}