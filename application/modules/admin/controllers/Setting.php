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

    public function linenoti()
    {
        $this->setBread(
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'],
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'ตั้งค่า'],
            ['class' => 'active', 'ref' => '#', 'name' => ' ตั้งค่า line Notification']
        );

        //Js

        $this->renderview('admin/view');
    }
    public function adduser()
    {
        $this->setBread(
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'],
            ['class' => '', 'ref' => base_url('dashboard'), 'name' => 'ตั้งค่า'],
            ['class' => 'active', 'ref' => '#', 'name' => 'เพิ่มผู้ใช้งาน']
        );
        $this->renderview('admin/view');
    }
}
