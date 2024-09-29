<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'PHPMailer/src/Exception.php';
require_once 'PHPMailer/src/PHPMailer.php';
require_once 'PHPMailer/src/SMTP.php';

$mail = new PHPMailer(true);

$alert = ''; // Initialize $alert variable

if (isset($_POST['submit'])) {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $mailFrom = isset($_POST['email']) ? $_POST['email'] : '';
    $message = isset($_POST['say']) ? $_POST['say'] : '';

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'snehamatkar3@gmail.com';
        $mail->Password = 'tvvjnplcbptveeuw';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->setFrom('snehamatkar3@gmail.com');
        $mail->addAddress('snehamatkar7@gmail.com');
        $mail->isHTML(true);
        $mail->Subject = 'Message Received from contact: ' . $name;
        $mail->Body = "Name: $name<br>Email: $mailFrom<br>Message: $message";
        $mail->send();
        $alert = 'success';
    } catch (Exception $e) {
        $alert = 'error';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contact Form Submission</title>
</head>
<body>

<!-- Display the response message on the HTML page -->
<div id="response-message"></div>

<!-- Include the script for handling form submission -->
<script>
    // Check the value of $alert and display a message accordingly
    var alertValue = '<?php echo $alert; ?>';
    var messageContainer = document.getElementById('response-message');

    if (alertValue === 'success') {
        messageContainer.innerHTML = '<div class="alert-success"><span>Message Sent! Thanks For Contacting Us</span></div>';
        // Optionally, you can redirect to another page after success
        // window.location.href = 'success-page.php';
    } else if (alertValue === 'error') {
        messageContainer.innerHTML = '<div class="alert-error"><span>An error occurred. Please try again.</span></div>';
    }
</script>

</body>
</html>
