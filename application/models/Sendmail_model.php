<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sendmail_model extends CI_Model
{
	public function sendtomail($subject, $data)
	{
		require_once 'assets/PHPMailer/class.phpmailer.php';
		if ($_SERVER['HTTP_HOST'] == 'gts.geerang.com' || 'betatest.geerang.com') {
			$mail = new PHPMailer();
			$mail->CharSet = "utf-8";
			$mail->IsHTML(true);
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;
			$mail->SMTPAuth = true;
			$mail->Username = "noreply@noreply.com"; // account SMTP
			$mail->Password = "P@ssw0rd2017"; // รหัสผ่าน SMTP 
			$mail->Host = 'mail.geerang.com';
			// $mail->SMTPSecure = 'tls';
			$mail->Port = 587;
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);
			$mail->SetFrom('support@geerang.com', 'support@geerang.com');
			$mail->Subject = $subject;

			$mail->MsgHTML($data['message']);

			$mail->AddAddress($data['email'], $data['email']); // ผู้รับคนที่หนึ่ง
			//$mail->AddAddress("admin@ramacme.local", "recipient2"); // ผู้รับคนที่สอง

			//Attach the uploaded file
			if (isset($data['uploadfile']['tmp_name'])) {
				foreach ($data['uploadfile']['tmp_name'] as $key => $value) {
					$mail->addAttachment($value, $data['uploadfile']['name'][$key]);
				}
			}

			if (!$mail->Send()) {
				return array('result' => "Mailer Error: " . $mail->ErrorInfo);
			} else {
				return array('result' => "success");
			}
		} else {
			$mail = new PHPMailer();
			$mail->CharSet = "utf-8";
			$mail->IsHTML(true);
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;
			$mail->SMTPAuth = true;
			// $mail->SMTPSecure = 'tls';
			$mail->Username = "noreply@secret-serv.com"; // account SMTP
			$mail->Password = "P@ssw0rd0979284920"; // รหัสผ่าน SMTP 
			$mail->Host = 'mail.secret-serv.com';
			// $mail->Username = "noreply@geerang.com"; // account SMTP
			// $mail->Password = "P@ssw0rd2017"; // รหัสผ่าน SMTP 
			// $mail->Username = "support@geerang.com"; // account SMTP
			// $mail->Password = "Xw02S9fDW"; // รหัสผ่าน SMTP 

			$mail->Port = 25;
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);

			if (!empty($data["mailsend"])) {
				$mail->SetFrom($data["mailsend"], $data["mailsend"]);
			} else {
				$mail->SetFrom('support@geerang.com', 'support@geerang.com');
			}

			$mail->Subject = $subject;

			$mail->MsgHTML($data['message']);

			$mail->AddAddress($data['email'], $data['email']); // ผู้รับคนที่หนึ่ง
			//$mail->AddAddress("admin@ramacme.local", "recipient2"); // ผู้รับคนที่สอง

			//Attach the uploaded file
			if (isset($data['uploadfile']['tmp_name'])) {
				foreach ($data['uploadfile']['tmp_name'] as $key => $value) {
					$mail->addAttachment($value, $data['uploadfile']['name'][$key]);
				}
			}

			if (!$mail->Send()) {
				return array('result' => "Mailer Error: " . $mail->ErrorInfo);
			} else {
				return array('result' => "success");
			}
		}
	}
}
