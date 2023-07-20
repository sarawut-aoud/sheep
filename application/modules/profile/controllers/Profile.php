<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');

        $this->load->model('Profile/Profile_model', 'profile');

        // javascript
        $this->setJs('/assets/js/croppie.js');
        $this->setJs('/assets/js_modules/profile.js?ft=' . time());

        if (!$this->session->userdata('pd_id')) {
            redirect('/home', 'refresh');
        }
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

        $this->data['result'] = $this->profile->get_userdata();

        $this->renderview('profile/edit');
    }
}
