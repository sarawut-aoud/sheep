<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

/**
 * [ Controller File name : Dashboard.php ]
 * สำหรับ Front-End
 */
class Process extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Register_model', 'regis');
        $this->load->model('sendmail/Send_email_model', 'sendmail');
    }


    public function Login()
    {
    }
    public function register()
    {
        $post = $this->input->post();
        $id = $this->regis->register($post);
        if ($id) {
            self::SetEmailSend($id);
        }
    }



    private function SetEmailSend($id)
    {
        $mailsend = '';
        $mailto = '';
        $subject = '';
        $bodyhtml = '';

        $sendmail_result = $this->sendEventmail($mailsend, $mailto, $subject, $bodyhtml, $uploadfile = '');


        if ($sendmail_result['result'] != "success") {
            $json =  '';
        } else {
            $json = json_encode(array(
                'status' => true,
                'message' => 'สมัครสมาชิกสำเสร็จ โปรดตรวจสอบที่ Email',
                'response' => $sendmail_result
            ));
        }

        return $json;
    }

    private function sendEventmail($mailsend, $mailto, $subject, $bodyhtml, $uploadfile = "")
    {
        $datamail = array(
            'email' => $mailto, 'message' => $bodyhtml, 'mailsend' => $mailsend, 'uploadfile' => $uploadfile
        );
        $result = $this->Sendmail_model->sendtomail($subject, $datamail);
        return $result;
    }
    public function Logout()
    {
        $this->session->sess_destroy();

        redirect('home', 'refresh');
    }
}
/*---------------------------- END Controller Class --------------------------------*/
