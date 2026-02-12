<?php
/**
 * Requires the "PHP Email Form" library
 * Upload path: ../assets/vendor/php-email-form/php-email-form.php
 */

$receiving_email_address = 'nexgenteckcom@gmail.com'; // change this

if (!file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
  die('Unable to load the "PHP Email Form" Library!');
}
include $php_email_form;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  die('Invalid request method.');
}

$name    = trim($_POST['name'] ?? '');
$contact = trim($_POST['contact'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $message === '') {
  die('Please fill in all required fields.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  die('Invalid email address.');
}

$mail = new PHP_Email_Form;
$mail->ajax = true;

$mail->to = $receiving_email_address;
$mail->from_name = $name;
$mail->from_email = $email;
$mail->subject = ($subject !== '') ? $subject : 'New Contact Form Submission';

$mail->add_message($name, 'From');
$mail->add_message($contact, 'Contact');
$mail->add_message($email, 'Email');
$mail->add_message($message, 'Message', 10);

echo $mail->send();
?>

