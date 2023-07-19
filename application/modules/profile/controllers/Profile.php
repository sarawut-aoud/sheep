<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');

        $this->load->model('Profile/Profile_model', 'profile');


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
}
