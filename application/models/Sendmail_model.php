<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Sendmail_model extends CI_Model
{
	public function sendtomail($subject, $data)
	{
		require_once 'assets/PHPMailer/class.phpmailer.php';
		if ($_SERVER['HTTP_HOST'] == 'sheeps.secret-serv.com') {
			$mail = new PHPMailer();
			$mail->CharSet = "utf-8";
			$mail->Mailer = 'stmp';
			$mail->IsHTML(true);
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;
			$mail->SMTPAuth = true;
			$mail->SMTPAutoTLS = false;
			$mail->Username = "info@goatgether.com"; // account SMTP
			$mail->Password = "!P@ssw0rd8694"; // รหัสผ่าน SMTP 
			$mail->Host = 'mail.secret-serv.com';
			$mail->SMTPSecure = 'false';
			$mail->Port = 587;
			$mail->SMTPOptions = array(
				'ssl' => array(
					'verify_peer' => false,
					'verify_peer_name' => false,
					'allow_self_signed' => true
				)
			);
			$mail->SetFrom('info@goatgether.com', 'info@goatgether.com');
			$mail->Subject = $subject;

			$mail->MsgHTML($data['message']);

			$mail->AddAddress($data['email'], $data['email']); // ผู้รับคนที่หนึ่ง

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
			$mail->Mailer = 'stmp';
			$mail->IsHTML(true);
			$mail->IsSMTP();
			$mail->SMTPDebug = 0;
			$mail->SMTPAuth = true;
			$mail->SMTPAutoTLS = false;
			$mail->SMTPSecure = 'false';
			$mail->Username = "info@goatgether.com"; // account SMTP
			$mail->Password = "!P@ssw0rd8694"; // รหัสผ่าน SMTP 
			$mail->Host = 'mail.secret-serv.com';
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
				$mail->SetFrom('info@goatgether.com', 'info@goatgether.com');
			}

			$mail->Subject = $subject;

			$mail->MsgHTML($data['message']);

			$mail->AddAddress($data['email'], $data['email']); // ผู้รับคนที่หนึ่ง

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
	public function emailTemplate($options = [
        'title' => 'Title',
		'subtitle' => null,
        'content' => '',
    ],$image = 'https://img.freepik.com/free-vector/people-with-technology-devices_52683-34717.jpg')
    {	
		$decor = [
			'title' => "padding: 16px 0px;",
			'subtitle' => "color: #c5c5c5;font-size: 14px;text-align: center;",
			'topic' => "font-size:20px;text-align: center;",
			'content' => "padding:12px;border-radius: 12px;background-color: #FFFFFF;margin:6px",
			'footer' => "padding-top: 26px;border: 1px #c5c5c5; border-radius: 12px;",
			'footer_image' => "width: 80px; height: 80px;"
		];
        $style = "<style>
                    table {
                        border-collapse: collapse!important;
                    }
                    tbody {
                        display: table-row-group;
                        vertical-align: middle;
                        border-color: inherit;
                    }
                </style>";
        return "<html>
                    <head>
                        $style
                    </head>
                    <body>
                    <div>
                        <table style='width: 100%'>
                            <tbody>
                                <td align='center'>
                                    <table width='650px'>
                                        <tbody>
                                            <tr align='center'>
												<img style='width: 100%' src='".$image."'>
                                            </tr>
											<tr align='center'>
												<div style='".$decor['title']."'>
													<div style='".$decor['topic']."'>".$options['title']."</div>
													<div style='".$decor['subtitle']."'>{$options['subtitle']}</div>
												</div>
											</tr>
											<tr>
												<div style='background-color: #CCCCCC;padding: 2px;border-radius: 12px;'>
													<div style='".$decor['content']."'>
														{$options['content']}
													</div>
												</div>
											</tr>
											<tr align='center'>
												<div style='".$decor['footer']."'>
													<img style='".$decor['footer_image']."' src='https://sheeps.secret-serv.com/assets/images/sheep.png'>
												</div>
											</tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tbody>
                        </table>
                        
                    </div>
                    </body>
                </html>";
    }
}
