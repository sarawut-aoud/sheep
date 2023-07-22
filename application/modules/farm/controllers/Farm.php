<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Farm extends CRUD_Controller
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
        $this->setBread(['class' => '', 'ref' => base_url('dashboard'), 'name' => 'หน้าแรก'], ['class' => 'active', 'ref' => '#', 'name' => 'ข้อมูลฟาร์ม']);
        $this->renderview('farm/view');
    }
    public function create_sheep()
    {
        $this->renderview('farm/create_sheep');
    }
}
