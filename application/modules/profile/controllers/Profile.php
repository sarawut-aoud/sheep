<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');

        $this->load->model('Profile/Profile_model', 'profile');

        // CSS
        $this->setCss('/assets/css/croppie.css');
        // javascript
        $this->setJs('/assets/js/croppie.js');

        $this->setJs('/assets/js_modules/profile.js?ft=' . time());

        if (!$this->session->userdata('pd_id')) {
            redirect('/home', 'refresh');
        }

        $this->upload_store_path = './assets/uploads/profile/';
    }
    public function index()
    {
        $this->setBread(['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'], ['class' => 'active', 'ref' => '#', 'name' => 'ข้อมูลส่วนตัว']);
        $this->data['result'] = $this->profile->get_userdata();
        $this->renderview('profile/view');
    }
    public function edit()
    {
        $this->setBread(['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'], ['class' => '', 'ref' => '#', 'name' => 'ข้อมูลส่วนตัว'], ['class' => 'active', 'ref' => '#', 'name' => 'แก้ไขข้อมูลส่วนตัว']);
        $this->renderview('profile/edit');
    }
    public function getdata()
    {
        try {
            $result = $this->profile->get_userdata()[0];
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function updatepic()
    {
        $post = (object) $this->input->post(NULL, FALSE);
        try {
            $data = $post->pictrue;

            $img_arr_a = explode(";", $data);
            $img_arr_b = explode(",", $img_arr_a[1]);

            $data = base64_decode($img_arr_b[1]);
            $img_name = encrypt(time()) . '.png';

            //create folder;
            $dir = $this->upload_store_path . (date('Y') + 543);
            if (!is_dir($dir)) {
                $dir_p = explode('/', $dir);
                for ($a = 1; $a <= count($dir_p); $a++) {
                    @mkdir(implode('/', array_slice($dir_p, 0, $a)));
                }
            }
            $file_path = $this->upload_store_path . (date('Y') + 543) . '/' . $img_name;

            $response = file_put_contents($file_path, $data);
            $post->pictrue = $file_path;

            if (!empty($response)) {
                $result = $this->profile->updatepic($post);

                if ($result == false) {
                    $message = 'error';
                    $ok = FALSE;
                } else {
                    $this->session->set_userdata("picture", $file_path);
                    $message = 'บันทึกข้อมูลเรียบร้อย';
                    $ok = TRUE;
                }
            } else {
                $ok = FALSE;
                $message = 'อัพโหลดไม่สำเร็จ';
            }
            $this->setRes($ok, $message, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
    public function updateprofile()
    {
        $post = (object) $this->input->post(NULL, FALSE);
        try {
            $result = $this->profile->updateprofile($post);
            $this->setRes(true, $result, 200);
        } catch (Exception $e) {
            $this->response(__METHOD__);
        }
    }
}
