<?php
if (!defined('BASEPATH'))  exit('No direct script access allowed');

class Process extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Register_model', 'regis');
        $this->load->model('Sendmail_model', 'sendmail');
        $this->load->model('Users_login_model', 'login');
    }


    public function Login()
    {

        $result = $this->login->user_validate();
        if ($result) {
            $status = true;
            $msg = 'ล็อกอินสำเร็จ';
        } else {
            $status = false;
            $msg = 'ไม่พบผู้ใช้งานนี้';
        }
        echo json_encode(['status' => $status, 'msg' => $msg]);
    }
    public function register()
    {
        $post = $this->input->post();
        $id = $this->regis->register($post);
        if ($id['id']) {
            self::SetEmailSend($id);
        }
        echo json_encode(['status' => true, 'msg' => 'ลงทะเบียนสำเร็จ']);
    }

    public function checkemail()
    {
        $post = (object) $this->input->post();

        $result = $this->db->query("SELECT email FROM db_sheep.personaldocument WHERE email = '{$post->email}' AND status = 1 ")->num_rows();

        if ($result == 0) {
            $msg = 'ไม่พบอีเมลล์ในระบบ';
            $status = false;
        } else {
            $msg = '';
            $status = true;
        }
        echo json_encode(['status' => $status, 'msg' => $msg]);
    }

    private function SetEmailSend($id)
    {
        $result = $this->db->get_where('db_sheep.personaldocument', ['pd_id' => $id['id']])->row();

        $mailto = $result->email;
        $subject = 'สมัครสมาชิก';
        $mailsend = 'info@goatgether.com';
        // $mailsend = $post->email;
        $subject = 'ขอรหัสผ่านใหม่';
        $body = "
        <div>สมัครสมาชิก</div>
        <div>สมัครสมาชิกสำเสร็จโปรดตรวจสอบชื่อเข้าใช้งานและรหัสผ่าน</div>
        <div>username : {$result->username} </div>
        <div>password :  {$id['pass']} </div>
        <br>
        <div>
            <a href='" . base_url() . "' style='border-radius:8px;padding: .5rem 1rem;background-color: #1875ff;color: white;'>คลิกเพื่อเข้าสู่ระบบ</a>
        </div>
        ";

        $tempalte = [
            'title' => 'สมัครสมาชิก',
            'subtitle' => null,
            'content' =>  $body,
        ];
        $bodyhtml =  $this->sendmail->emailTemplate($tempalte);
        $sendmail_result = $this->sendEventmail($mailsend, $mailto, $subject, $bodyhtml, $uploadfile = '');


        // if ($sendmail_result['result'] != "success") {
        //     $json =  '';
        // } else {
        //     $json = json_encode(array(
        //         'status' => true,
        //         'message' => 'สมัครสมาชิกสำเสร็จ โปรดตรวจสอบที่ Email',
        //         'response' => $sendmail_result
        //     ));
        // }

        // return $json;
    }

    private function sendEventmail($mailsend, $mailto, $subject, $bodyhtml, $uploadfile = "")
    {
        $datamail = array(
            'email' => $mailto, 'message' => $bodyhtml, 'mailsend' => $mailsend, 'uploadfile' => $uploadfile
        );
        $result = $this->sendmail->sendtomail($subject, $datamail);
        return $result;
    }

    public function usernamecheck()
    {
        $post = (object)$this->input->post();
        $status = false;
        $msg = 'ไม่สามารถใช้ชื่อเข้าใช้งานนี้ได้';
        $result = $this->db->query("SELECT username FROM db_sheep.personaldocument WHERE username = '$post->username'");
        if ($result->num_rows() == 0) {
            $status = true;
            $msg = '';
        }
        if ($post->username == '') {
            $status = false;
            $msg = '';
        }
        echo json_encode(array(
            'status' => $status,
            'data' => $msg,
        ));
    }
    public function emailcheck()
    {
        $post = (object)$this->input->post();
        $status = false;
        $msg = 'ไม่สามารถใช้อีเมลล์นี้ได้';
        $result = $this->db->query("SELECT email FROM db_sheep.personaldocument WHERE email = '$post->email'");
        if ($result->num_rows() == 0) {
            $status = true;
            $msg = '';
        }
        if ($post->email == '') {
            $status = false;
            $msg = '';
        }
        echo json_encode(array(
            'status' => $status,
            'data' => $msg,
        ));
    }
    public function Logout()
    {
        $this->session->sess_destroy();

        redirect('home', 'refresh');
    }
}
/*---------------------------- END Controller Class --------------------------------*/
