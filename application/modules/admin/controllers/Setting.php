<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Setting extends CRUD_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->config('preallocate');
        $this->pd_id = $this->session->userdata('pd_id');


        if (!$this->session->userdata('pd_id')) {
            redirect('/home', 'refresh');
        }
    }

    public function index()
    {
        $this->setBread(
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'],
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'ตั้งค่า'],
            ['class' => 'active', 'ref' => '#', 'name' => ' ตั้งค่า Line Notifications / เพิ่มผู้ใช้งาน']
        );

        //Js

        $this->renderview('admin/view');
    }
}
