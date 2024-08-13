<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

$mail = new PHPMailer;

$mail->isSMTP(); // Set mailer to use SMTP
$mail->Host = 'mail.empire-wynfield.ca'; // Specify main and backup SMTP servers
$mail->SMTPAuth = true; // Enable SMTP authentication
$mail->Username = 'info@empire-wynfield.ca'; // SMTP username
$mail->Password = 'empire-wynfield'; // SMTP password
$mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587; // TCP port to connect to

$mail->setFrom('info@empire-wynfield.ca', $_POST['name']);
$mail->addAddress('contact@homebaba.ca');

$mail->addReplyTo($_POST['email']);
$mail->isHTML(true);

$mail->Subject = "Empire Wyndfield - Landing Page Inquiry";
$message = '<html>

<body>';
$message .= '<table rules="all" style="border:none;" cellpadding="3">';
$message .= "<tr>
            <td><strong>Name:</strong> </td>
            <td>" . strip_tags($_POST['name']) . "</td>
        </tr>";
$message .= "<tr>
            <td><strong>Phone:</strong> </td>
            <td>" . strip_tags($_POST['phone']) . "</td>
        </tr>";
$message .= "<tr>
            <td><strong>Email:</strong> </td>
            <td>" . strip_tags($_POST['email']) . "</td>
        </tr>";
$message .= "<tr>
            <td><strong>Message : </strong> </td>
            <td>" . strip_tags($_POST['message']) . "</td>
        </tr>";
$message .= "<tr>
            <td><strong>Source : </strong> </td>
            <td>empire-wynfield.ca</td>
        </tr>";
$message .= "</table>";
$message .= "</body>

</html>";

$mail->Body = $message;
$mail->AltBody = $_POST['message'] . $_POST['email'] . $_POST['name'] . $_POST['phone'];

if (!$mail->send()) {
    $_SESSION["error"] = "Application not submitted!";

    header('Location: index.php');
    exit();

} else {
    $_SESSION["success"] = "Application submitted.";
    header('Location: ./');
    exit();

}

?>