<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');
        $this->load->model('Sendmail_model', 'sendmail');
    }

    public function index()
    {
        $this->setJs('/assets/js_modules/login.js?ft=' . time());
        $this->render_main('home/login');
    }
    public function register()
    {
        $this->data['title']   =  $this->config->item('title_option_th');
        $this->setJs('/assets/js_modules/register.js?ft=' . time());
        $this->render_main('home/register');
    }
    public function forgetpassword()
    {
        $this->setJs('/assets/js_modules/forgetpassword.js?ft=' . time());
        $this->render_main('home/forget_password');
    }

    public function sendforgetpassword()
    {
        $post = (object)$this->input->post(NULL, false);
    }
    private function SetEmailSend($id)
    {
        $result = $this->db->get_where('db_sheep.personaldocument', ['pd_id' => $id['id']])->row();
        $mailsend = 'noreply@noreply.com';
        $mailto = $result->email;
        $subject = 'สมัครสมาชิก';
        $bodyhtml = " สมัครสมาชิกสำเสร็จโปรดตรวจสอบชื่อเข้าใช้งานและรหัสผ่าน" . "\n";
        $bodyhtml = "username :" . $result->username . "\n";
        $bodyhtml = "password :" . $id['pass'] . "\n\n\n\n";
        $bodyhtml = "<a href='" . base_url() . "'>คลิกเพื่อเข้าสู่ระบบ</a>";

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
}
