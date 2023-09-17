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
        $result = $this->db->get_where('db_sheep.personaldocument', ['email' => $post->email])->row();
        $pass = $this->db->get_where('db_sheep.log_pass_id', ['pd_id' => $result->pd_id])->row();

        $mailsend = 'noreply@secret-serv.com';
        // $mailsend = $post->email;
        $mailto = $post->email;
        $subject = 'ขอรหัสผ่านใหม่';
        $body = "
        <div>รหัสผ่านของท่านคือ</div>
        <div>password : $pass->pass</div>
        <br>
        <div>
            <a href='" . base_url() . "' style='border-radius:8px;padding: .5rem 1rem;background-color: #1875ff;color: white;'>คลิกเพื่อเข้าสู่ระบบ</a>
        </div>
        ";

        $tempalte = [
            'title' => 'ขอรหัสผ่านใหม่',
            'subtitle' => null,
            'content' =>  $body,
        ];
        $bodyhtml =  $this->sendmail->emailTemplate($tempalte);
        $sendmail_result = $this->sendEventmail($mailsend, $mailto, $subject, $bodyhtml, $uploadfile = '');


        if ($sendmail_result['result'] != "success") {
            $json =  '';
        } else {
            $json = json_encode(array(
                'status' => true,
                'message' => 'ส่งรหัสผ่านใหม่แล้ว โปรดตรวจสอบที่ Email',
                'response' => $sendmail_result
            ));
        }

        echo $json;
    }

    private function sendEventmail($mailsend, $mailto, $subject, $bodyhtml, $uploadfile = "")
    {
        $datamail = array(
            'email' => $mailto, 'message' => $bodyhtml, 'mailsend' => $mailsend, 'uploadfile' => $uploadfile
        );
        $result = $this->sendmail->sendtomail($subject, $datamail);
        return $result;
    }
}
