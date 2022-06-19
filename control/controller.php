<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
class Controller {
    function __construct() {
    	session_start();
    	//error_reporting(E_ERROR | E_PARSE);
		//require_once 'model/db.php';
		//$this->model=new dbconn();
		

	}
	function user_id()
	{
		return $_SESSION["User_id"];
	}
	function user_type()
	{
		return $_SESSION["type"];
	}
	function index() {
		require_once 'view/index.html';
	}
	function inspectionlist() {
		require_once 'view/inspectionlist.html';
	}
	function report_view() {
		require_once 'view/report.html';
	}
	function signin() {
		require_once 'view/sign-in.html';
	}
	function signup() {
		require_once 'view/sign-up.html';
	}
	function inspection()
	{
		require_once 'view/inspection_submit.html';
	}
	function view_profile()
	{
		require_once 'view/my-profile.html';
	}
	function view_inspection_page()
	{
		require_once 'view/pdf.html';
	}

	
	function php_gmail_mailer($to_email,$to_name,$body)
	{
		

//		require_once __DIR__ . 'vendor/phpmailer/src/Exception.php';
//		require_once __DIR__ . 'vendor/phpmailer/src/PHPMailer.php';
//		require_once __DIR__ . 'vendor/phpmailer/src/SMTP.php';

		require_once  'vendor/phpmailer/src/Exception.php';
		require_once  'vendor/phpmailer/src/PHPMailer.php';
		require_once  'vendor/phpmailer/src/SMTP.php';

		// passing true in constructor enables exceptions in PHPMailer
		$mail = new PHPMailer(true);

		try {
		    // Server settings
		    $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER; // for detailed debug output
		    $mail->isSMTP();
		    $mail->Host = 'smtp.gmail.com';
		    $mail->SMTPAuth = true;
		    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
		    $mail->Port = 587;

		    $mail->Username = 'aru.happy.tech@gmail.com'; // YOUR gmail email
		    $mail->Password = 'Aru@12345'; // YOUR gmail password

		    // Sender and recipient settings
		    $mail->setFrom('aru.happy.tech@gmail.com', 'Happy Tech');
		    $mail->addAddress($to_email, $to_name);
		    $mail->addReplyTo('aru.happy.tech@gmail.com', 'Happy Tech'); // to set the reply to

		    // Setting the email content
		    $mail->IsHTML(true);
		    $mail->Subject = "Happy Tech Mail Responce";
		    $mail->Body = $body;
		    $mail->AltBody = 'automatic-system-generated-email';

		    $mail->send();
		    echo "Email message sent.";
		} catch (Exception $e) {
		    echo "Error in sending email. Mailer Error: {$mail->ErrorInfo}";
		}
	}
}